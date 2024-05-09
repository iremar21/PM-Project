<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Plan;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Devuelve las tareas activas asignadas al usuario con sesión iniciada
    public function index() {
        
        $tasks = Task::orderBy('scheduledFinishDate', 'asc')
            ->where('completed', false)
            ->where('assigned_user_id', auth()->id())
            ->paginate(10);

        $taskCount = $tasks->count();

        return view('dashboard', compact('tasks', 'taskCount'));

    }

    // Devuelve la vista individual de la tarea seleccionada
    public function show(Task $task) {

        $task->load('plan.tasks');

        return view('tasks/show', compact('task'));

    }

    // Devuelve la vista con el formulario para crear y asignar una nueva tarea al plan seleccionado
    // Únicamente puedrá crear tareas dentro de un plan el creador o el responsable de éste
    public function create(Plan $plan) {

        if ($plan->creator->id != auth()->user()->id && $plan->manager->id != auth()->user()->id) {
            return redirect()->route('plans.show', $plan);
        }

        $users = User::all();

        return view('tasks/create', compact('users', 'plan'));

    }

    // Guarda la nueva tarea, asignándosela al plan seleccionado
    public function store(Plan $plan, StoreTaskRequest $request) {

        if ($plan->creator->id != auth()->user()->id && $plan->manager->id != auth()->user()->id) {
            return redirect()->route('plans.show', $plan);
        }

        $task = Task::create([
            'title' => $request->title,
            'plan_id' => $plan->id,
            'description' => $request->description,
            'assigned_user_id' => $request->assigned_user_id,
            'scheduledFinishDate' => $request->scheduledFinishDate,
            'creator_user_id' => auth()->id(),
            'completed' => false
        ]);

        $task->save();

        // Actualizar el porcentaje completado (campo 'status') del plan al añadir una nueva tarea
        $tasks = Task::where('plan_id', $task->plan->id)->get();
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('completed', true)->count();
        $percentageCompleted = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        $task->plan->update(['status' => $percentageCompleted]);
        
        // Si el porcentaje completado no alcanza 100 el plan se marcará como no completado
        // En caso de que ya estuviera como completado, se borrará la fecha de finalización previa
        if ($percentageCompleted != 100) {
            $task->plan->update(['completed' => false]);
            $task->plan->update(['finishDate' => null]);
        }
        

        return redirect()->route('tasks.show', $task);

    }

    // Devuelve la vista con el formulario para editar la tarea
    // solo podrá acceder el usuario que la haya creado
    public function edit(Task $task) {

        if ($task->creator_user_id != auth()->user()->id) {
            return redirect()->route('tasks.show', $task);
        }

        $users = User::all();

        return view('tasks/edit', compact('task', 'users'));

    }

    // Actualiza la información de la tarea
    public function update(Request $request, Task $task) {

        if ($task->creator_user_id != auth()->user()->id) {
            return redirect()->route('tasks.show', $task);
        }

        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'assigned_user_id' => 'required',
            'scheduledFinishDate' => 'required',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->assigned_user_id = $request->assigned_user_id;
        $task->scheduledFinishDate = $request->scheduledFinishDate;

        $user = auth()->user();

        $task->save();

        return view('tasks/show', compact('task', 'user'));

    }

    // Devuelve las tareas creadas por el usuario de la sesión
    public function getTasksByMe() {

        $tasks = Task::orderBy('scheduledFinishDate', 'asc')
        ->where('creator_user_id', auth()->id())
        ->paginate(10);

        return view ('tasksByMe', compact('tasks'));

    }

    // Buscar tareas activas del usuario de la sesión por título o plan
    public function search(Request $request) {

        $search = $request->input('search', '');

        $tasks = Task::where('assigned_user_id', auth()->id())
            ->where('completed', false)
            ->where(function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
                })
                ->orWhereHas('plan', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%");
                });
            })
            ->paginate(10);
    
        $tasks->appends(['search' => $search]);
    
        return view('dashboard', compact('tasks', 'search'));

    }

    // Buscar tareas completadas del usuario de la sesión por título o plan
    public function searchPastTasks(Request $request) {

        $search = $request->input('search', '');
        $tasks = Task::where('completed', true)
            ->where('assigned_user_id', auth()->id())
            ->where(function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
                })
                ->orWhereHas('plan', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%");
                });
            })
            ->paginate(10);
    
        $tasks->appends(['search' => $search]);
    
        return view('tasks/past', compact('tasks', 'search'));

    }

    // Buscar tareas creadas por el usuario de la sesión por título o plan
    public function searchTasksByMe(Request $request) {

        $search = $request->input('search', '');
        $tasks = Task::where('creator_user_id', auth()->id())
            ->where(function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                ->orWhereHas('plan', function($q) use ($search) {
                    $q->where('title', 'like', "%$search%");
                });
            })
            ->paginate(10);

        $tasks->appends(['search' => $search]);

        return view('tasksByMe', compact('tasks', 'search'));
        
    }

    // Marca una tarea como completada
    // únicamente podrá hacerlo el usuario al que ha sido asignada
    public function markAsCompleted(Task $task) {

        if ($task->assignee->id != auth()->user()->id) {
            return redirect()->route('dashboard');
        }

        $task->completed = true;
        $task->finishDate = now();

        $task->save();
        $plan = $task->plan;

        // Actualizar el porcentaje completado (campo 'status') del plan al completar una tarea
        $tasks = Task::where('plan_id', $task->plan->id)->get();
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('completed', true)->count();
        $percentageCompleted = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        $task->plan->update(['status' => $percentageCompleted]);

        // Si el porcentaje completado alcanza 100 el plan se marcará como completado
        if ($percentageCompleted == 100) {
            $task->plan->update(['completed' => true]);
            $task->plan->update(['finishDate' => now()]);
        }

        return redirect()->route('tasks.show', compact('task', 'plan'));

    }

    // Devuelve una lista de tareas ya completadas por el usuario de la sesión
    public function getPastTasks() {

        $tasks = Task::orderBy('finishDate', 'desc')
            ->where('completed', true)
            ->where('assigned_user_id', auth()->id())
            ->paginate(10);

        $taskCount = $tasks->count();

        return view('tasks/past', compact('tasks', 'taskCount'));

    }

    // Elimina la tarea seleccionada
    // únicamente podrá hacerlo el usuario que la haya creado
    public function destroy(Task $task) {

        if ($task->creator_user_id != auth()->user()->id) {
            return redirect()->route('tasks.show', $task);
        }

        $task->delete();
        $plan = $task->plan;

        return view('plans/show', compact('plan'));

    }
}

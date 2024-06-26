<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Models\Category;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    // Devuelve los planes activos
    public function index() {

        $plans = Plan::orderBy('scheduledFinishDate', 'asc')
            ->where('completed', false)
            ->paginate(10);

        return view('plans/activePlans', compact('plans'));
    }

    // Devuelve la vista individual del plan seleccionado
    // junto con las tareas asignadas a éste
    public function show(Plan $plan) {

        $plan->load('tasks');
        
        return view('plans/show', compact('plan'));

    }

    // Devuelve la vista con el formulario para crear un nuevo plan
    public function create() {

        $categories = Category::all();
        $users = User::all();

        return view('plans/create', compact('categories', 'users'));

    }

    // Guarda el nuevo plan
    public function store(StorePlanRequest $request) {

        $plan = Plan::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'creator_user_id' => auth()->id(),
            'manager_user_id' => $request->manager_user_id,
            'scheduledFinishDate' => $request->scheduledFinishDate,
            'creationDate' => now(),
            'slug' => Str::slug($request->title),
        ]);

        $plan->save();

        return view('plans/show', compact('plan'));

    }

    // Devuelve la vista con el formulario para editar el plan seleccionado
    // Únicamente puede editar un plan el usuario que lo ha creado
    public function edit(Plan $plan) {

        if ($plan->creator->id != auth()->user()->id) {
            return redirect()->route('plans.show', $plan);
        }

        $categories = Category::all();
        $users = User::all();

        return view('plans/edit', compact('plan', 'categories', 'users'));

    }

    // Guarda los cambios efectuados por el creador del plan
    public function update(Request $request, Plan $plan) {

        if ($plan->creator->id != auth()->user()->id) {
            return redirect()->route('plans.show', $plan);
        }

        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'category_id' => 'required',
            'manager_user_id' => 'required',
            'scheduledFinishDate' => 'required',
            'slug' => 'unique'
        ]);

        $plan->title = $request->title;
        $plan->description = $request->description;
        $plan->category_id = $request->category_id;
        $plan->manager_user_id = $request->manager_user_id;
        $plan->scheduledFinishDate = $request->scheduledFinishDate;
        $plan->slug = Str::slug($request->title);

        $user = auth()->user();

        $plan->save();

        return view('plans/show', compact('plan', 'user'));

    }

    // Devuelve los planes creados por el usuario de la sesión
    public function getPlansByMe() {

        $plans = Plan::orderBy('scheduledFinishDate', 'asc')
        ->where('creator_user_id', auth()->user()->id)
        ->paginate(10);

        return view('plansByMe', compact('plans'));

    }

    // Devuelve los planes dirigidos por el usuario de la sesión
    public function getPlansManagedByMe() {

        $plans = Plan::orderBy('scheduledFinishDate', 'asc')
        ->where('manager_user_id', auth()->user()->id)
        ->paginate(10);

        return view('plansManagedByMe', compact('plans'));

    }

    // Devuelve planes pasados (ya completados)
    public function getPastPlans() {

        $plans = Plan::orderBy('finishDate', 'desc')
            ->where('completed', true)
            ->paginate(10);

        $plansCount = $plans->count();

        return view('plans/past', compact('plans', 'plansCount'));

    }

    // Buscar planes activos por título, descripción o categoría
    public function search(Request $request) {

        $search = $request->search;

        $plans = Plan::where('completed', false)
        ->where(function($query) use ($search) {

            $query->where('title', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%");

        })->orWhereHas('category', function($query) use ($search) {

                $query->where('name', 'like', "%$search%");
 
        })->paginate(10);

        $plans->appends(['search' => $search]);

        return view('plans/activePlans', compact('plans', 'search'));

    }

    // Buscar planes completados por título, descripción o categoría
    public function searchPastPlans(Request $request) {

        $search = $request->search;

        $plans = Plan::where('completed', true)->
        where(function($query) use ($search) {

            $query->where('title', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%");

        })->orWhereHas('category', function($query) use ($search) {

            $query->where('name', 'like', "%$search%");

        })->paginate(10);

        $plans->appends(['search' => $search]);

        return view('plans/past', compact('plans', 'search'));

    }

    // Busca planes creados por el usuario de la sesión por título, descripción o categoría
    public function searchPlansByMe(Request $request) {

        $search = $request->search;
    
        $plans = Plan::where('creator_user_id', auth()->id())
                     ->where(function($query) use ($search) {
                         $query->where('title', 'like', "%$search%")
                               ->orWhere('description', 'like', "%$search%")
                               ->orWhereHas('category', function($query) use ($search) {
                                   $query->where('name', 'like', "%$search%");
                               });
                     })
                     ->paginate(10);

        $plans->appends(['search' => $search]);
    
        return view('plansByMe', compact('plans', 'search'));

    }

    // Busca planes dirigidos por el usuario de la sesión por título, descripción o categoría
    public function searchPlansManagedByMe(Request $request) {

        $search = $request->search;
    
        $plans = Plan::where('manager_user_id', auth()->id())
                     ->where(function($query) use ($search) {
                         $query->where('title', 'like', "%$search%")
                               ->orWhere('description', 'like', "%$search%")
                               ->orWhereHas('category', function($query) use ($search) {
                                   $query->where('name', 'like', "%$search%");
                               });
                     })
                     ->paginate(10);

        $plans->appends(['search' => $search]);
    
        return view('plansManagedByMe', compact('plans', 'search'));
        
    }

    // Borra el plan seleccionado
    // únicamente podrá hacerlo el usuario que haya creado el plan
    public function destroy(Plan $plan) {

        if ($plan->creator->id != auth()->user()->id) {
            return redirect()->route('plans.show', $plan);
        }

        $plan->delete();

        return redirect()->route('plans');

    }
}

<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Vista pública
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth/login');
});

// Rutas de usuario autenticado
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/tasksByMe', [TaskController::class, 'getTasksByMe'])->name('dashboard.tasksByMe');
    Route::get('/dashboard/plansByMe', [PlanController::class, 'getPlansByMe'])->name('dashboard.plansByMe');
    Route::get('/dashboard/plansManagedByMe', [PlanController::class, 'getPlansManagedByMe'])->name('dashboard.plansManagedByMe');

    // Búsquedas en el dashboard
    Route::get('/dashboard/search', [TaskController::class, 'search'])->name('dashboard.search');
    Route::get('/dashboard/tasksByMe/search', [TaskController::class, 'searchTasksByMe'])->name('dashboard.searchTasksByMe');
    Route::get('/dashboard/plansByMe/search', [PlanController::class, 'searchPlansByMe'])->name('dashboard.searchPlansByMe');
    Route::get('/dashboard/plansManagedByMe/search', [PlanController::class, 'searchPlansManagedByMe'])->name('dashboard.searchPlansManagedByMe');


    // Perfiles de usuarios (autogestión del perfil)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Planes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans');
    Route::get('/plans/search', [PlanController::class, 'search'])->name('plans.search');
    Route::get('/plans/pastPlans/search', [PlanController::class, 'searchPastPlans'])->name('plans.past.search');
    Route::get('/plans/pastPlans', [PlanController::class, 'getPastPlans'])->name('plans.past');
    Route::get('/plans/show/{plan}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans/create/store', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/edit/{plan}', [PlanController::class, 'edit'])->name('plans.edit');
    Route::patch('/plans/update/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/delete/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

    // Tareas
    Route::get('/tasks/pastTasks', [TaskController::class, 'getPastTasks'])->name('tasks.past');
    Route::get('/tasks/pastTasks/search', [TaskController::class, 'searchPastTasks'])->name('tasks.past.search');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/create/{plan}', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store/{plan}', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/completed/{task}', [TaskController::class, 'markAsCompleted'])->name('tasks.completed');
    Route::delete('/tasks/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

});

// RUTAS DE ADMINISTRADOR

// Gestión de usuarios
Route::group(['middleware' => ['can:admin.users']], function() {
    Route::get('/admin/users', [UserController::class, 'index'])->name('users');
    Route::get('/admin/users/search', [UserController::class, 'search'])->name('users.search');
    Route::patch('/admin/users/changeStatus/{user}', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('/admin/users/create', [RegisteredUserController::class, 'create'])->name('users.create');
    Route::post('/admin/users/store', [RegisteredUserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/admin/users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Gestión de categorías
Route::group(['middleware' => ['can:admin.categories']], function() {
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/admin/categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/admin/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// FIN RUTAS DE ADMINISTRADOR

require __DIR__.'/auth.php';

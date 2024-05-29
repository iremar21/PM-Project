<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Devuelve una lista de todos los usuarios
    public function index() {
        
        $users = User::with('roles')->paginate(10);

        return view('admin/users/index', compact('users'));

    }

    // Devuelve la vista con el formulario para editar la información del usuario
    public function edit(User $user) {

        $roles = Role::all();

        return view('admin/users/edit', compact('user', 'roles'));

    }

    // Guarda la información actualizada del usuario
    // Utilizamos el ProfileUpdateRequest proporcionado por el paquete
    public function update(UserUpdateRequest $request, User $user) {

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->roles()->sync($request->roles);
    
        $user->save();
    
        return redirect(route('users'));

    }

    // Cambia el estado del usuario entre activo o desactivado
    // Sin necesidad de eliminar el usuario, imposibilitamos su acceso a la aplicación
    public function changeStatus(User $user) {

        !$user->active ? $user->active = true : $user->active = false;

        $user->save();

        return redirect()->route('users');

    }

    // Buscar usuarios por nombre o email
    // FALTARÍA PODER BUSCAR POR ROL
    public function search(Request $request) {

        $search = $request->search;

        $users = User::where(function($query) use ($search){

            $query->where('name','like',"%$search%")
            ->orWhere('email','like',"%$search%");

        })->paginate(10);

        return view('admin/users/index', compact('users', 'search'));

    }

    // Elimina el usuario seleccionado
    // Si el usuario tiene tareas asignadas, devuelve un mensaje de error
    public function destroy(User $user) {

        DB::beginTransaction();

        try {

            $user->delete();

            $users = User::paginate(10);

            DB::commit();

            return redirect()->route('users', compact('users'));

        } catch (Exception $e) {
            
            DB::rollBack();

            $users = User::paginate(10);

            $message = 'El usuario seleccionado no se puede eliminar porque tiene tareas asignadas.';

            return redirect()->route('users', compact('users'))->withError($message);
        }

    }
}

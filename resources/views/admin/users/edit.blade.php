@extends('layouts.template')

@section('content')
<div class="max-w-2xl">
    <a class="mb-4 inline-flex items-center text-sm text-gray-600 decoration-2 hover:underline" href="{{route('users')}}">
        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Volver
      </a>
    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Editar usuario</h2>
</div>
<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Nombre')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$user->name}}" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$user->email}}" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Contraseña')" />

        <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Role -->
    <div class="mt-4">
        <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asignar Rol</label>
        <select id="role" name="roles[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{$user->roles->contains($role->id) ? 'selected' : ''}}>{{ $role->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">

        <x-primary-button class="ms-4">
            {{ __('Actualizar') }}
        </x-primary-button>
    </div>


</form>
@endsection



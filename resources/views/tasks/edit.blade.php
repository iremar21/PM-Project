@extends('layouts.template')

@section('content')

<section class="bg-white">
    <div class="mx-auto max-w-2xl lg:py-16">
        <a class="mb-4 inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline" href="{{route('tasks.show', $task)}}">
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Volver
          </a>
        <h2 class="mb-4 text-xl font-bold text-gray-900">Editar tarea del plan de acción "{{$task->plan->title}}"</h2>
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Título</label>
                    <input type="text" name="title" id="title" value="{{ $task->title }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="assigned_user_id" class="block mb-2 text-sm font-medium text-gray-900">Asignar a:</label>
                    <select id="assigned_user_id" name="assigned_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{$task->assigned_user_id == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('assigned_user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                    <textarea id="description" name="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500">{{ $task->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="scheduledFinishDate" class="block mb-2 text-sm font-medium text-gray-900">Fecha prevista de finalización:</label>
                    <input type="datetime-local" name="scheduledFinishDate" id="scheduledFinishDate" value="{{ $task->scheduledFinishDate }}" class="form-input mt-1 block w-full focus:border-blue-500 focus:ring focus:ring-blue-200 border-2 border-indigo-500/50 rounded">
                    @error('scheduledFinishDate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Actualizar</button>
        </form>
    </div>
</section>

@endsection
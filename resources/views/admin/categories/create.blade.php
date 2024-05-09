@extends('layouts.template')

@section('content')

<section class="bg-white">
    <div class="mx-auto max-w-2xl lg:py-16">
        <a class="mb-4 inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline" href="{{route('categories')}}">
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Volver
          </a>
        <h2 class="mb-4 text-xl font-bold text-gray-900">Crear nueva categoría</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Crear</button>
        </form>
    </div>
</section>

@endsection

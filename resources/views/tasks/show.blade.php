@extends('layouts.template')

@section('content')
    <!-- Blog Article -->
<div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="grid lg:grid-cols-3 gap-y-8 lg:gap-y-0 lg:gap-x-6">
      <!-- Content -->
      <div class="lg:col-span-2">
        <div class="py-8 lg:pe-8">
          <div class="space-y-5 lg:space-y-8">
            <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline" href="{{route('dashboard')}}">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
              Volver al dashboard
            </a>
            <div class="flex justify-between">
              <h3 class="mt-1 text-base font-medium uppercase text-gray-500">Tarea</h3>
              <div class="flex justify-end space-x-8">
                @if ($task->creator_user_id == auth()->user()->id)
                <a href="{{route('tasks.edit', $task)}}" class="text-blue-600">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                  </svg>                  
                </a>
                <form action="{{route('tasks.destroy', $task)}}" method="POST" class="text-red-600">
                  @csrf
                  @method("DELETE")
                  <button class="submit" onclick="return confirm('¿Estás seguro de que quieres borrar la tarea?')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>   
                  </button>
                </form>
              @endif
              </div>
            </div>
  
            <h2 class="text-3xl font-bold lg:text-5xl">{{$task->title}}</h2>
  
            <div class="flex items-center gap-x-5">
              <p class="inline-flex items-center gap-1.5 py-1 px-3 sm:py-2 sm:px-4 rounded-full text-xs sm:text-sm bg-gray-100 text-gray-800" href="#">
                {{$task->plan->category->name}}
              </p>
              <p class="text-xs sm:text-sm text-gray-800">Creada por {{$task->creator->name}} el {{Carbon\Carbon::parse($task->created_at)->format('d-m-Y')}}</p>
            </div>
            <div>
              <p class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-base bg-blue-100 text-blue-800">Asignada a <span class="font-medium">{{$task->assignee->name}}</span> | 
                @if ($task->completed == false)
                  Fecha prevista de finalización: <span class="font-medium">{{Carbon\Carbon::parse($task->scheduledFinishDate)->format('d-m-Y')}}</span>
                @else
                  Completada el <span class="font-medium">{{Carbon\Carbon::parse($task->finishDate)->format('d-m-Y')}}</span>
                @endif
              </p>
            </div>
  
            <p class="text-lg text-gray-800">{{$task->description}}</p>
    
            <div class="grid lg:flex lg:justify-between lg:items-center gap-y-5 lg:gap-y-0">
  
              <div class="flex justify-end items-center gap-x-1.5">
  
                <div class="block h-3 border-e border-gray-300 mx-3">
                    @if ($task->assigned_user_id == Auth::user()->id && $task->completed == false)
                    <form action="{{route('tasks.completed', $task)}}" method="POST">
                      @method('PATCH')
                      @csrf
                      <button type="submit" class="flex justify-between focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg> 
                        <p>Marcar como completada</p>
                      </button>
                    </form>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Content -->
  
      <!-- Sidebar -->
      <div class="lg:col-span-1 lg:w-full lg:h-full lg:bg-gradient-to-r lg:from-gray-50 lg:via-transparent lg:to-transparent">
        <div class="sticky top-0 start-0 py-8 lg:ps-8">

          <div class="group flex items-center gap-x-3 border-b border-gray-200 pb-8 mb-8">
  
            <a class="group grow block" href="{{route('plans.show', $task->plan)}}">
                <h5 class="group-hover:text-gray-600 text-sm font-semibold text-gray-800">
                    Tarea del plan de acción
                </h5>

                <h5 class="group-hover:text-gray-600 text-lg font-bold text-gray-800">
                    {{$task->plan->title}}
                </h5>
                <p class="text-sm text-gray-500">
                    {{round($task->plan->status, 2)}}% completado
                </p>
            </a>
          </div>
  
          <div class="space-y-6">
            <a class="group flex items-center gap-x-6">
              <div class="grow">
                <h5 class="mb-3 text-lg font-bold text-gray-800">
                    Tareas dentro de este plan:
                </h5>
                @foreach ($task->plan->tasks as $relatedTask)
                <li class="mb-4 text-sm font-semibold text-blue-600 list-none">
                  <div class="flex flex-col bg-white border shadow-sm rounded-xl p-4 md:p-5">
                    <h3 class="text-lg font-bold text-gray-800">
                      <a class="hover:text-gray-600 hover:underline" href="{{route('tasks.show', $relatedTask)}}">
                        {{$relatedTask->title}}
                      </a>
                    </h3>
                    <p class="mt-1 text-xs font-medium uppercase text-gray-500">
                      Asignada a {{$relatedTask->assignee->name}}
                    </p>
                    <p class="mt-2 text-gray-500">
                      @if ($relatedTask->completed)
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800">Completada</span>
                      @else
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>
                      @endif
                    </p>
                  </div>

                </li>
                @endforeach

              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
    </div>
  </div>
  <!-- End Blog Article -->
@endsection
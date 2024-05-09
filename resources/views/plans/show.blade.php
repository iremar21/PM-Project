@extends('layouts.template')

@section('content')
    <!-- Blog Article -->
<div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="">
      <!-- Content -->
      <div class="lg:col-span-2">
        <div class="py-8 lg:pe-8">
          <div class="space-y-5 lg:space-y-8">
            <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline" href="{{route('plans')}}">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
              Volver a la lista de planes
            </a>
            <div class="flex justify-between">
              <h3 class="mt-1 text-base font-medium uppercase text-gray-500 dark:text-neutral-500">Plan de acción</h3>
              <div class="flex justify-end space-x-8">
                @if ($plan->creator->id == auth()->user()->id)
                <a href="{{route('plans.edit', $plan)}}" class="text-blue-600">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                  </svg>                  
                </a>
                <form action="{{route('plans.destroy', $plan)}}" method="POST" class="text-red-600">
                  @csrf
                  @method("DELETE")
                  <button class="submit" onclick="return confirm('¿Estás seguro de que quieres borrar el plan? Todas sus tareas se borrarán también')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>   
                  </button>                         
                </form>
              @endif
              </div>
            </div>

            <div>
              <h2 class="text-3xl font-bold lg:text-5xl">{{$plan->title}}</h2>
              <p class="mt-3 text-lg font-base text-gray-800">Responsable del plan: <span class="font-medium">{{ $plan->manager->name }}</span></p>
            </div>

  
            <div class="flex items-center gap-x-5">
              <a class="inline-flex items-center gap-1.5 py-1 px-3 sm:py-2 sm:px-4 rounded-full text-xs sm:text-sm bg-gray-100 text-gray-800 hover:bg-gray-200" href="#">
                {{$plan->category->name}}
              </a>
              <p class="text-xs sm:text-sm text-gray-800">Creado por {{$plan->creator->name}} el {{Carbon\Carbon::parse($plan->created_at)->format('d-m-Y')}}</p>
            </div>
            <div>
              <p class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-base bg-blue-100 text-blue-800"><span class="font-medium">{{round($plan->status, 2)}}% completado</span> |
                @if ($plan->completed == false)
                  Fecha prevista de finalización: <span class="font-medium">{{Carbon\Carbon::parse($plan->scheduledFinishDate)->format('d-m-Y')}}</span></p>
                @else
                  Finalizado el <span class="font-medium">{{Carbon\Carbon::parse($plan->finishDate)->format('d-m-Y')}}</span>
                @endif
            </div>
  
            <p class="text-lg text-gray-800">{{$plan->description}}</p>
    
            <div class="grid lg:flex lg:justify-between lg:items-center gap-y-5 lg:gap-y-0">
  
              <a class="group flex items-center gap-x-6" href="#">
                <div class="grow">
                  <h5 class="mb-3 hover:text-gray-600 text-lg font-bold text-gray-800">
                      Tareas dentro de este plan:
                  </h5>
                  @if($plan->creator->id == auth()->user()->id || $plan->manager->id == auth()->user()->id)
                  <div>
                    <a href="{{route('tasks.create', $plan)}}" class="mb-4 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                      <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                      Añadir tarea
                    </a>
                  </div>
                  @endif
                  @if (count($plan->tasks) > 0)
                    @foreach ($plan->tasks as $task)
                    <li class="mb-4 text-sm font-semibold text-blue-600 hover:underline list-none">
                      <div class="flex flex-col bg-white border shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                          <a href="{{route('tasks.show', $task->id)}}">
                            {{$task->title}}
                          </a>
                        </h3>
                        <p class="mt-1 text-xs font-medium uppercase text-gray-500 dark:text-neutral-500">
                          Asignada a {{$task->assignee->name}}
                        </p>
                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                          {{$task->description}}
                        </p>
                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                          @if ($task->completed)
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">Completada</span>
                          @else
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500">Pendiente</span>
                          @endif
                        </p>
                      </div>
                    </li>
                    @endforeach
                  @else 
                    <p class="text-xs sm:text-sm">Todavía no hay tareas asignadas a este plan</p>
                  @endif
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Content -->
    </div>
  </div>
  <!-- End Blog Article -->
@endsection
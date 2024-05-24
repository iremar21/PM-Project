@extends('layouts.template')

@section('content')
    <!-- Table Section -->
<div class="max-w-[85rem] px-4 sm:px-6 mx-auto">
  @if (session('error'))
  <div class="flex justify-center">
    <span class="mb-4 py-4 px-4 inline-flex items-center gap-x-1 text-base bg-red-100 border-2 border-red-300 text-red-800 rounded-md">
      <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
      </svg>
      {{session('error')}}
    </span>
  </div>
  @endif
    <!-- Card -->
    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
              <div>
                <h2 class="text-xl font-semibold text-gray-800">
                  Planes completados
                </h2>
              </div>
  
              <div>
                <div class="inline-flex gap-x-2">
                  <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="{{route('plans.create')}}">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Añadir plan de acción
                  </a>
                </div>
              </div>
            </div>
            <!-- End Header -->

            <!-- Search Bar -->
            <div class="mb-2 mt-2 min-w-full">
              <form class="max-w-md mx-auto" method="GET" action="{{route('plans.past.search')}}">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="search" name="search" value="{{ isset($search) ? $search : ''}}" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar por título, descripción o categoría..." required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Buscar</button>
                </div>
              </form>
            </div>
            <!-- End Search Bar -->
  
            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="ps-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                        Plan de acción
                      </span>
                    </div>
                  </th>
  
                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                        Categoría
                      </span>
                    </div>
                  </th>
  
                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                        Fecha Fin
                      </span>
                    </div>
                  </th>
                </tr>
              </thead>
  
              <tbody class="divide-y divide-gray-200">
                @foreach ($plans as $plan)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="size-px whitespace-nowrap">
                            <a class="block relative z-10" href="{{route('plans.show', $plan)}}">
                            <div class="px-6 py-2">
                                <div class="block text-sm text-blue-600 decoration-2 hover:underline">{{$plan->title}}</div>
                            </div>
                            </a>
                        </td>
                        <td class="size-px whitespace-nowrap">
                            <a class="block relative z-10">
                            <div class="px-6 py-2">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-gray-100 text-gray-800">
                                {{$plan->category->name}}
                                </span>
                            </div>
                            </a>
                        </td>
                        <td class="size-px whitespace-nowrap">
                          <a class="block relative z-10">
                            <div class="px-6 py-2">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-gray-100 text-gray-800">
                                {{Carbon\Carbon::parse($plan->finishDate)->format('d-m-Y')}}
                                </span>
                            </div>
                            </a>
                        </td>
                        <td class="size-px whitespace-nowrap">
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table -->
  
            <!-- Footer -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
              <div>
                <div class="inline-flex gap-x-2">
                  {{$plans->links()}}
                </div>
              </div>
            </div>
            <!-- End Footer -->
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>
  <!-- End Table Section -->
@endsection


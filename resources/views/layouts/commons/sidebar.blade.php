<!-- Sidebar Toggle Button -->
<button type="button" class="py-2 px-3 flex justify-center items-center gap-x-1.5 text-xs rounded-lg border border-gray-200 text-gray-500 hover:text-gray-600 lg:hidden" id="sidebarToggle" aria-label="Sidebar">
    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 12h18M3 6h18M3 18h18"/>
    </svg>
    <span class="sr-only">Sidebar</span>
</button>

<!-- Sidebar -->
<div id="application-sidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 lg:block">
    <div class="flex items-center gap-4 mt-5 ml-4">
        <x-application-logo />
        <p class="text-xl font-semibold" aria-label="Brand">The Plan Manager</p>
    </div>

    <nav class="p-6 w-full flex flex-col flex-wrap">
        <ul class="space-y-1.5">
          <li>
              <a class="{{Route::is('dashboard') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('dashboard')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                      <polyline points="9 22 9 12 15 12 15 22"/>
                  </svg>
                  Dashboard
              </a>
          </li>

          <li>
              <a class="{{Route::is('plans.create') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('plans.create')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                  </svg>
                  Crear plan
              </a>
          </li>

          <li>
              <a class="{{Route::is('plans') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('plans')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                      <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                  </svg>
                  Planes en curso
              </a>
          </li>

          <li>
              <a class="{{Route::is('tasks.past') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('tasks.past')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                      <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                  </svg>
                  Mi historial de tareas
              </a>
          </li>

          <li>
              <a class="{{Route::is('plans.past') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('plans.past')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                  </svg>
                  Histórico de planes
              </a>
          </li>

          @can('admin.users')
          <li>
              <a class="{{Route::is('users') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('users')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                      <circle cx="9" cy="7" r="4"/>
                      <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                  </svg>
                  Usuarios
              </a>
          </li>
          @endcan

          @can('admin.categories')
          <li>
              <a class="{{Route::is('categories') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('categories')}}">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                      <path d="M6 6h.008v.008H6V6Z"/>
                  </svg>
                  Categorías
              </a>
          </li>
          @endcan

          <li>
              <a class="{{Route::is('profile.edit') ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full bg-gray-100 text-gray-500' : ''}} w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="{{route('profile.edit')}}">
                  <svg class="flex-shrink-0 mt-0.5 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="18" cy="15" r="3"/>
                      <circle cx="9" cy="7" r="4"/>
                      <path d="M10 15H6a4 4 0 0 0-4 4v2"/>
                      <path d="m21.7 16.4-.9-.3"/>
                      <path d="m15.2 13.9-.9-.3"/>
                      <path d="m16.6 18.7.3-.9"/>
                      <path d="m19.1 12.2.3-.9"/>
                      <path d="m19.6 18.7-.4-1"/>
                      <path d="m16.8 12.3-.4-1"/>
                      <path d="m14.3 16.6 1-.4"/>
                      <path d="m20.7 13.8 1-.4"/>
                  </svg>
                  Cuenta
              </a>
          </li>
      </ul>
  </nav>
</div>
<!-- End Sidebar -->

<!-- Overlay for sidebar -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 hidden lg:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('application-sidebar');
        const overlay = document.getElementById('sidebarOverlay');
    
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
    
        overlay.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    });
    </script>
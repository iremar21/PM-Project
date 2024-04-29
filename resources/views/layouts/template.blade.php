<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- favicon -->
    <!-- estilos -->
</head>
<body>
    <!-- header -->
    <!-- nav -->

    @include('layouts.commons.header')
    
    @include('layouts.commons.sidebar')

    <div class="w-full lg:ps-64">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            @yield('content')
        </div>
    </div>

    <!-- footer -->

    <!-- script -->
</body>
</html>
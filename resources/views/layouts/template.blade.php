<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- favicon -->
    <!-- estilos -->
</head>
<body class="flex flex-col min-h-screen">
    <!-- header -->
    @include('layouts.commons.header')
    
    <!-- Main content wrapper -->
    <div class="flex flex-1">
        @include('layouts.commons.sidebar')

        <!-- Page content -->
        <div class="flex-1 p-4 sm:p-6 space-y-4 sm:space-y-6">
            @yield('content')
        </div>
    </div>

    <!-- footer -->

    <!-- script -->
</body>
</html>
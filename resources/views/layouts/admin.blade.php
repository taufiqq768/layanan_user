<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Layanan Aplikasi N1</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')
</head>
<body>
    <x-sidebar>
        @yield('content')
    </x-sidebar>

    @yield('scripts')
</body>
</html>

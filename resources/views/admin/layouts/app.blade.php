<!DOCTYPE html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title') | {{ config('app.name', 'Berna Violinist') }}
    </title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body>
    @include('admin.layouts.partials.header')
    <main class="p-4 sm:ml-64 mt-20">
        @include('admin.layouts.partials.sidebar')
        @yield('content')
        @include('web.layouts.partials.footer')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>

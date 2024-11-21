@props([
    'pageTitle' => '...',
    'pageDescription' => '...',
    'pageHeadLine' => '...',
    'pagekeywords' => '...',
    'imageUri' =>asset('icon.png'),
])



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ Str::limit($pageDescription, 155) }}">
    <meta name="revisit-after" content="1 days">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="{{ asset('ai-logo.svg') }}" type="image/x-icon" loading="lazy">

    <meta name="keywords" content="{{ $pagekeywords }}, {{ $pageTitle }} , {{ request()->url() }}">
    <meta name="author" content="Shop Manager">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="electronicshop.kesug.com/">
    <meta name="twitter:title" content="{{ Str::limit(__('appName') . ' ' . $pageHeadLine, 35) }}">
    <meta name="twitter:description" content="{{ Str::limit($pageDescription, 65) }}">
    <meta name="twitter:creator" content="Shop Manager">
    <meta name="twitter:image" content="{{ $imageUri??asset('icon.png') }}">

    <meta property="og:title" content="{{ Str::limit(__('appName') . ' ' . $pageHeadLine, 35) }}">
    <meta property="og:description" content="{{ Str::limit($pageDescription, 65) }}">
    <meta property="og:url" content="electronicshop.kesug.com/">
    <meta property="og:image:alt" content="electronics">
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="electronics" />
    <meta property="fb:admins" content="manager" />
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:image:secure_url" content="{{ $imageUri??asset('icon.png') }}">
    <meta property="og:image" itemprop="image" content="{{ $imageUri??asset('icon.png') }}" />

    <title>{{ __('appName') }} - {{ Str::limit($pageTitle . ' ' . $pageDescription, 55) }} </title>

    <link rel="canonical" href="{{ request()->fullUrl() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>


</head>

<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>
 
    <!-- Page wrapper -->
    <div class="flex h-[100dvh] overflow-hidden">

        <x-app.sidebar :variant="$attributes['sidebarVariant']"  />


        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if ($attributes['background']) {{ $attributes['background'] }} @endif"
            x-ref="contentarea">

            <x-app.header :variant="$attributes['headerVariant']" :pageTitle=$pageTitle>
                
                <x-slot name="searchModal">
                    {{ $searchModal ?? '' }}
                </x-slot>
            </x-app.header >
                <main class="grow " style="      direction:{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    {{ $slot }}
                </main>

        </div>

    </div>
    <x-app.footer/>
    {{-- :quickLinks= {{$sideBarLinks }} --}}
   
    @livewireScriptConfig
</body>

<script>
    // Function to set the theme
    function setTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }

    // On checkbox toggle
    document.getElementById('light-switch').addEventListener('change', function() {
        if (this.checked) {
            setTheme('dark');
        } else {
            setTheme('light');
        }
    });

    // On page load, set the theme based on localStorage value
    document.addEventListener('DOMContentLoaded', function() {
        const storedTheme = localStorage.getItem('theme') || 'light';
        const lightSwitch = document.getElementById('light-switch');

        // Check the checkbox state based on the stored theme
        lightSwitch.checked = storedTheme === 'dark';

        // Set the initial theme
        setTheme(storedTheme);
    });
</script>

</html>



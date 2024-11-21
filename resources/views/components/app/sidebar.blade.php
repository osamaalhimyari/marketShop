<?php

$userSlideBarLinks = [
    [
        'name' => 'homePage',
        'GoTo' => route('homePage'),
        'iconPath' => 'home-icon.svg',
        'iconPathDark' => 'home-icon-dark.svg',
    ],
    [
        'name' => 'cart',
        'GoTo' => route('cart'),
        'iconPath' => 'cart-icon.svg',
        'iconPathDark' => 'cart-icon-dark.svg',
    ],

    [
        'name' => 'history',
        'GoTo' => route('history'),
        'iconPath' => 'history-icon.svg',
        'iconPathDark' => 'history-icon-dark.svg',
    ],
    // [
    //     'name' => 'login',
    //     'GoTo' => route('login'),
    //     'iconPath' => 'login-icon.svg',
    //     'iconPathDark' => 'login-icon-dark.svg',
    // ],
];
$adminSlideBarLinks = [
    [
        'name' => 'dashboard',
        'GoTo' => route('admin-dashboard'),
        'iconPath' => 'dashboard-icon.svg',
        'iconPathDark' => 'dashboard-icon-dark.svg',
    ],
    [
        'name' => 'products',
        'GoTo' => route('admin-controll-Products'),
        'iconPath' => 'product-icon.svg',
        'iconPathDark' => 'product-icon-dark.svg',
    ],
    [
        'name' => 'categories',
        'GoTo' => route('categories.index'),
        'iconPath' => 'category-icon.svg',
        'iconPathDark' => 'category-icon-dark.svg',
    ],
    [
        'name' => 'currencies',
        'GoTo' => route('currencies.index'),
        'iconPath' => 'currency-icon.svg',
        'iconPathDark' => 'currency-icon-dark.svg',
    ],
    [
        'name' => 'homePage',
        'GoTo' => route('homePage'),
        'iconPath' => 'home-icon.svg',
        'iconPathDark' => 'home-icon-dark.svg',
    ],
    [
        'name' => 'cart',
        'GoTo' => route('cart'),
        'iconPath' => 'cart-icon.svg',
        'iconPathDark' => 'cart-icon-dark.svg',
    ],

    [
        'name' => 'history',
        'GoTo' => route('history'),
        'iconPath' => 'history-icon.svg',
        'iconPathDark' => 'history-icon-dark.svg',
    ],
    [
        'name' => 'logout',
        'GoTo' => route('logout'),
        'iconPath' => 'logout-icon.svg',
        'iconPathDark' => 'logout-icon-dark.svg',
    ],
];
?>




<div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

<div id="sidebar"
    class="flex lg:!flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-sm' }}"
    :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
    @keydown.escape.window="sidebarOpen = false">
    <div class="flex justify-between mb-10 pr-3 sm:px-2">
        <!-- Close button -->
        <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
            aria-controls="sidebar" :aria-expanded="sidebarOpen">
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
            </svg>
        </button>
        <!-- Logo -->
        <a aria-label="Skip to main content" class="block" href="{{ route('homePage') }}">
            <x-app.logo />
        </a>
        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
            :class="open ? '' : 'hover:text-gray-900 dark:hover:text-white'" href="#0"
            @click.prevent="open = !open; sidebarExpanded = true">

            <div class="flex items-center justify-between">
                <sub><span
                        class="text-2xl block text-gray-800 dark:text-gray-100  hover:text-gray-900 dark:hover:text-white">
                        Market Shop</span></sub>
            </div>
        </a>
    </div>

    <!-- Links -->
    <div class="space-y-8">


        <div>
            <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                    aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
            </h3>


            <ul>

                @if (Auth::check())
                    @foreach ($adminSlideBarLinks as $slideBarLink)
                        <x-sidebar-button :slideBarLink=$slideBarLink />
                    @endforeach
                @else
                    @foreach ($userSlideBarLinks as $slideBarLink)
                        <x-sidebar-button :slideBarLink=$slideBarLink />
                    @endforeach
                @endif
            </ul>

        </div>





    </div>

    <!-- Expand / collapse button -->


    <div class=" ml-auto    mt-200 flex justify-between">
        {{-- <div class="  pl-auto"> --}}
        <div class="block md:hidden  m-auto mr-10">
            <x-theme-toggle />
        </div>
        <div class="block md:hidden">
            <x-lang-change />
        </div>
        {{-- </div> --}}
    </div>



    <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
        <div class="w-12 pl-4 pr-3 py-2">
            <button
                class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                @click="sidebarExpanded = !sidebarExpanded">
                <span class="sr-only">Expand / collapse sidebar</span>
                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180"
                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path
                        d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                </svg>
            </button>
        </div>
    </div>

</div>

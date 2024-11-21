
<header
    class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 dark:max-lg:before:bg-gray-800/90 before:-z-10 z-30 {{ $variant === 'v2' || $variant === 'v3' ? 'before:bg-white after:absolute after:h-px after:inset-x-0 after:top-full after:bg-gray-200 dark:after:bg-gray-700/60 after:-z-10' : 'max-lg:shadow-sm lg:before:bg-gray-100/90 dark:lg:before:bg-gray-900/90' }} {{ $variant === 'v2' ? 'dark:before:bg-gray-800' : '' }} {{ $variant === 'v3' ? 'dark:before:bg-gray-900' : '' }}">

    <div class="bg-white dark:bg-gray-800">

        <div class="px-4 sm:px-6 lg:px-8">
            <div
                class="flex items-center justify-between h-16 {{ $variant === 'v2' || $variant === 'v3' ? '' : 'lg:border-b border-gray-200 dark:border-gray-700/60' }}">

                <!-- Header: Left side -->
                <div class="flex">

                    <!-- Hamburger button -->
                    <button class="text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 lg:hidden"
                        @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="5" width="16" height="2" />
                            <rect x="4" y="11" width="16" height="2" />
                            <rect x="4" y="17" width="16" height="2" />
                        </svg>
                    </button>

                </div>

                <!-- Header: Right side -->

                <center>
                    <span class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 ">{{ __($pageTitle) }}</span>
                </center>
                <div class="flex items-center space-x-4 md:space-x-10  justify-between">
                    <!-- Dark mode toggle -->

                    <div class="hidden md:block">
                        <x-lang-change />
                    </div>
                    <div class="hidden md:block">
                        <x-theme-toggle />
                    </div>
                    {{-- <x-modal-search /> --}}
                    {{ $searchModal ?? '' }}

                    <!-- Divider -->
                    <hr class="w-px h-6 bg-gray-200 dark:bg-gray-700/60 border-none" />


                    <x-cart-button :title="'cart'" />


                    @if ('sidebarOpen' == false)
                        <span> market shop</span>
                    @endif
                </div>

            </div>
        </div>
    </div>

</header>

<x-layouts.app :pageTitle="__('homePage')" :pageDescription="__('discribeSite')" :pagekeywords="$categories->pluck('name')->implode(', ')">
    <x-slot name="searchModal">
        <x-modal-search :rute="route('homePage')" />
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        @php
            $selectedCategoryId = request()->input('catid', 'all');
        @endphp

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .custom-scrollbar {
                scrollbar-width: none;
                /* Firefox */
                -ms-overflow-style: none;
                /* IE 10+ */
                overflow-y: scroll;
                /* keep scrolling functionality */
            }
        </style>


        @if ($searchTxt == null)

            <div class="px-4 py-2 mb-5 flex w-full h-16 overflow-x-auto custom-scrollbar space-x-2">
                <button onclick="location.href='?catid=all'"
                    class="px-4 py-2 font-medium tracking-wide whitespace-nowrap 
            {{ $selectedCategoryId == 'all' ? 'text-white bg-black dark:text-black dark:bg-white' : 'text-gray-700 bg-gray-200 dark:text-gray-300 dark:bg-gray-800' }} 
            transition-colors duration-300 
            transform rounded-lg focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-10 ml-2 mr-2">
                    {{ __('All') }}
                </button>

                @foreach ($categories as $category)
                    <button onclick="location.href='?catid={{ $category->id }}'"
                        class="px-4 py-2 font-medium tracking-wide whitespace-nowrap 
                {{ $selectedCategoryId == $category->id ? 'text-white bg-black dark:text-black dark:bg-white' : 'text-gray-700 bg-gray-200 dark:text-gray-300 dark:bg-gray-800' }} 
                transition-colors duration-300 
                transform rounded-lg focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-10 ml-2 mr-2">
                        {{ __($category->name) }}
                    </button>
                @endforeach
            </div>
        @else
            <div class="flex justify-center">
                <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 m-5 relative">
                    <a href="/" class="  mt-0 rtl:left-0 ltr:right-0  text-blue-700 dark:text-blue-400">
                        {{ __('homePage') }}
                    </a>
                    <p class="mt-4 text-gray-500 text-lg font-semibold dark:text-gray-300">
                        {{ __('ThisResults') }} "<span class="text-blue-700 dark:text-blue-400">
                            {{ $searchTxt }}</span>"
                    </p>
                </div>
            </div>

        @endif
        <!-- Product Cards -->
        @if (empty($products))
            <div class="flex justify-center">
                <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="text-center py-12">
                        <p class="mt-4 text-gray-500 text-lg font-semibold dark:text-gray-300">{{ __('noData') }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 gap-x-4 gap-y-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-3">
                @foreach ($products as $product)
                    <x-item-card :product="$product" />
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        </div>
       
</x-layouts.app>

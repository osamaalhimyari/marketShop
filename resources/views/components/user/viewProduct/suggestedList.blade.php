<div class="mt-8  bg-white dark:bg-gray-800  rounded-lg shadow-xl">
    <!-- Section Title -->
    <div class=" items-center mb-6">
        <div class="bg-blue-600 h-1 w-16 mr-3 rounded  ml-3 mr-3 mb-3"></div>
        <span class="text-xl font-bold font-extrabold text-gray-800 dark:text-gray-100  ml-3 mr-3 mb-3">{{ __('suggestion') }}</span>
    </div>

    <!-- Horizontal Scrollable Container for Product Cards -->
    <div class="relative w-full overflow-x-auto py-4 px-4 pr-4 bg-gray-700 dark:bg-gray-900">
        <!-- Product Cards Wrapper -->
        <div class="flex">
            @foreach ($products as $product)
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-2 transform hover:scale-105 transition-transform duration-300 ease-in-out flex-shrink-0 w-64 min-w-[16rem] ml-3 mr-3">
                    <!-- Product Card Component -->
                    <x-item-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>

</div>

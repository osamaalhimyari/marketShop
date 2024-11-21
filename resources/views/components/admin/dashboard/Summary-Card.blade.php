{{-- resources/views/components/OrderSummary.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex items-center transition-colors duration-300">
    <div class="flex-grow">
        <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200  text-center">{{ count($data??0) }}</h3>
        <h6 class="text-gray-700 dark:text-gray-200 text-ml">{{$title??""}}</h6>
    </div>
    <div class="text-4xl text-green-500">
        <a href="#">
            <span class="mdi mdi-basket-fill"></span>
        </a>
    </div>
</div>

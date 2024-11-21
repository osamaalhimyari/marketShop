<div class="product-rate-cover flex items-center space-x-2">
    <div class="product-rate w-24 bg-gray-200 dark:bg-gray-700 h-4 rounded overflow-hidden">
        <div class="product-rating bg-yellow-400 h-full" style="width:{{ min($product->views, 100) }}%;"></div>
    </div>
    <span class="text-gray-500 dark:text-gray-400 text-sm">({{$product->views}}) views</span>
</div>



{{-- ///// --}}
<div class="relative  shadow-lg rounded-lg p-4 max-w-xs">
    @if ($product->views > 500)
        <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
            {{ __('popular') }}
        </div>
    @elseif ($product->views > 50)
        <div class="absolute top-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
            {{ __('trending') }}
        </div>
    @else
        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
            {{ __('new') }}
        </div>
    @endif
   
</div>
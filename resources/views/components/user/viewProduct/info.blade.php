<div class="detail-info">
    <h5 class="text-2xl font-bold mb-4">{{ $product->title ?? '' }}</h5>
    <div class="product-detail-rating flex justify-between items-center mb-4">
        <div class="pro-details-brand">
            <span>{{ __('category') }}: <a href="#"
                    class="text-blue-600 dark:text-blue-400">{{ $product->category->name ?? '' }}</a></span>
        </div>
        <div class="flex items-center text-gray-600 dark:text-white text-xs font-medium space-x-1">

            <span>({{ $product->views }}) {{ __('views') }}</span>
        </div>
    </div>
    @php
        $discountedPrice = $product->price - $product->price * ($product->discount / 100);
    @endphp
    <div class="product-price text-primary mb-4">
        <span class="text-xl font-bold"><span class="text-gray-900 dark:text-white font-medium text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ $discountedPrice }}</span>
        <span class="text-gray-500 dark:text-gray-400 line-through ml-4 mr-4"><span class="text-gray-900 dark:text-white font-medium text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ $product->price ?? 0 }}</span>
        <span class="text-green-600 dark:text-green-400 font-medium ml-4 mr-4"> {{ __('discount') }}
            {{ $product->discount }}%</span>

            <div class="flex">
                {{ __('Availability') }}: 
                <p class="ml-5 mr-5 text-sm 
                    {{ $product->quantity < 0 ? 'text-red-500' : 'text-green-600' }} mb-2">
                    ({{ $product->quantity ?? '' }}) {{ __('inStock') }}
                </p>
            </div>
            
    </div>
    
    <div class="border-t border-gray-200 dark:border-gray-600 mt-4 mb-4"></div>
    <div class="product-sort-info mb-8">
        <ul>
            {{-- <li class="mb-2"><i class="fi-rs-refresh mr-2"></i> 30 Day Return Policy</li> --}}
            <li><span class="text-primary"> {{ $product->headLine }} </span></li>
        </ul>
    </div>
    <div class="border-t border-gray-200 dark:border-gray-600 mt-6 mb-6"></div>
    <div class="detail-extralink">

        {{ $slot }}

    </div>

   
</div>

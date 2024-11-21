<a  href="{{ route('product', ['Pid' => sha1($product->id)]) }}"
    class="group rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800 flex flex-col h-full">
     <div class="relative overflow-hidden bg-gray-200" style="height: 200px;">
         <!-- New Badge (only shown if the product is new) -->
         @if ($product->updated_at >= now()->subDays(30))
             <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
                 {{ __('new') }}
             </div>
         @endif
         <!-- Discount Badge (only shown if there is a discount) -->
         @if ($product->discount > 0)
             <div class="absolute top-2 right-2 bg-red-500 text-white text-s px-2 py-1 rounded-lg shadow">
                 {{ __('discount') }} <span class="text-ml">{{ $product->discount }}</span>%
             </div>
         @endif
         <!-- Product Image -->
         <img src="{{ url('storage') . '?img=' . ($product->product_images->first()->imagePath ?? '') }}"
              alt="{{ $product->name ?? 'Product image' }}" class="object-cover object-center w-full h-full" loading="lazy">
     </div>
 
     <div class="p-4 flex flex-col justify-between flex-grow">
         <h3 class="mt-2 text-lg font-large text-gray-900 dark:text-white">{{ $product->title }}</h3>
         
         @php
             $discountedPrice = $product->price - $product->price * ($product->discount / 100);
         @endphp
         
         <!-- Price and Button Section at the Bottom -->
         <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-4 mt-auto md:justify-between">
             <!-- Price Section -->
             <div class="flex flex-row md:flex-col items-center md:items-start gap-2">
                 @if ($product->discount > 0)
                     <!-- Discounted Price and Original Price -->
                     <span class="text-green-600 dark:text-white font-semibold text-ml md:text-xl"><span class="text-gray-900 dark:text-white font-medium text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ number_format($discountedPrice, 2) }}</span>
                     <span class="text-gray-500 dark:text-white line-through text-xs md:text-sm"><span class="text-gray-900 dark:text-white font-small text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ number_format($product->price, 2) }}</span>
                 @else
                     <!-- Regular Price -->
                     <span class="text-gray-900 dark:text-white font-medium text-ml md:text-xl"><span class="text-gray-900 dark:text-white font-medium text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ number_format($product->price, 2) }}</span>
                 @endif
             </div>                       
             
             <!-- Button -->
             <button class="bg-yellow-500 text-white px-4 py-2  rounded-lg hover:bg-yellow-600 transition-colors duration-300 w-full md:w-auto">
                 {{ __('buyNow') }}
             </button>
         </div>
     </div>
 </a>
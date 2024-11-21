<div class="md:col-span-2  mt-6 mr-2 ml-2 mb-4 lg:mb-0">
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <th class="px-4 py-2">{{ __('image') }}</th>
                    <th class="px-4 py-2">{{ __('product_name') }}</th>
                    <th class="px-4 py-2">{{ __('price') }}</th>
                    <th class="px-4 py-2">{{ __('quantity') }}</th>
                    <th class="px-4 py-2">{{ __('total') }}</th>
                    <th class="px-4 py-2"> </th>
                </tr>
            </thead>
            <tbody id="cart-items2">
                @foreach ($order->carts as $cart)
                    @php
                        $product = $cart->product;
                    @endphp
                    <tr class="p-6">
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4">
                            <img class="w-16 h-16 object-cover"
                                src="{{ url('storage') . '?img=' . ($product->product_images->first()->imagePath ?? '') }}"
                                alt="${product.title}">
                        </td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 whitespace-nowrap w-full">
                            {{ Str::limit($product->title, 50) . '...' }}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 whitespace-nowrap w-full">
                            {{ $globalConfig->currency->sign }} {{ $product->price }}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4">{{ $cart->quantity }}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 whitespace-nowrap w-full">
                            {{ $globalConfig->currency->sign }} {{ $cart->item_total_price }}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 mr-3 ml-3">
                            <a href="/product?Pid={{sha1($product->id)}}"
                                class="text-blue-500 hover:text-blue-700   font-bold">{{ __('show') }}</a>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <td colspan="4" class="text-right px-4 py-2 font-bold">{{ __('totalPrice') }}</td>
                    <td class="px-4 py-2 total-price text-green-800">{{ $globalConfig->currency->sign }}
                        {{ $order->total_price ?? 0.0 }}</td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>

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
                <!-- Cart items will be dynamically inserted here -->
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <td colspan="4" class="text-right px-4 py-2 font-bold">{{ __('totalPrice') }}</td>
                    <td class="px-4 py-2 total-price text-green-800">{{ $globalConfig->currency->sign }} 0.00</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('homePage') }}">

                            <button class="w-full bg-blue-600 text-white py-2 rounded-lg mt-6">

                                {{ __('continueShopping') }}
                            </button>
                        </a>
                    </td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>

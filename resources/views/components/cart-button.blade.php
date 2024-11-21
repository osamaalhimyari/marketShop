 
@props([
    'align' => 'right'
]) 

<div class="relative inline-flex" x-data="{ open: false }" >
    <a href="{{ route('cart') }}" @click="cartOpen = false">
        <button
        name="cart.button"
        aria-label="cart"
            class="btn bg-gray-900 rounded-[5px] p-2 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white"
            :class="{ 'bg-gray-200 dark:bg-gray-800': open }"
            aria-haspopup="true"
            @mouseenter="open = screen.width >= 768 ? true : false"
            @mouseleave="open = false"
            :aria-expanded="open"
        >
            <svg class="fill-current text-white dark:text-black" xmlns="http://www.w3.org/2000/svg" height="30px" width="30px" viewBox="0 -960 960 960">
                <path
                    d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
            </svg>
            <!-- Cart count display -->
            <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full px-1  " id="cart-count">0</span>
        </button>
    </a>
    <div
        class="origin-top-right z-10 absolute top-full min-w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1 {{$align === 'right' ? 'right-0' : 'left-0'}}"
        @mouseenter="open = screen.width >= 768 ? true : false"
        @mouseleave="open = false"
        x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        <div class="p-6 " style="      direction:{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <h2 class="text-xl font-semibold mb-4">Your Cart</h2>

            <div id="cart-empty-msg" class="text-gray-500">
                Your cart is empty.
            </div>

            <div id="cart-items-container">
                <table id="cart-items" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> {{__('image')}}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> {{__('product_name')}}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('price')}}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('quantity')}}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Cart items will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>

            <div class="shopping-cart-footer mt-4">
                <div class="shopping-cart-total flex justify-between">
                    <h4>Total</h4>
                    <span id="cart-total" class="font-semibold">$0</span>
                </div>

                <div class="shopping-cart-button mt-4 flex justify-end space-x-3">
                    <a href="{{ route('cart') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">{{__('View cart')}}</a>
                    {{-- <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded-md">Checkout</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadCartData() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartItemsTableBody = document.querySelector('#cart-items tbody');
        const cartEmptyMessage = document.getElementById('cart-empty-msg');
        const cartTotalElement = document.getElementById('cart-total');
        const cartCountElement = document.getElementById('cart-count');

        cartItemsTableBody.innerHTML = '';  // Clear previous items
        let totalPrice = 0;

        if (cart.length === 0) {
            cartEmptyMessage.style.display = 'block';
            cartItemsTableBody.style.display = 'none';
            cartTotalElement.innerText = '$0';
           
            cartCountElement.classList.add('hidden');
        } else {
            cartEmptyMessage.style.display = 'none';
            cartItemsTableBody.style.display = 'table-row-group';
            let productCount = 0;
            cart.forEach(item => {
                const imageUrl = "{{  url('storage') . '?img='  }}" + (item.image??''); 
                const itemRow = document.createElement('tr');

                itemRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="/cart">
                            <img class="w-16 h-16 object-cover" src="${imageUrl}" alt="${item.title}">

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <h4><a href="/product?Pid=${item.id}">${item.title}</a></h4>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        $${(item.price / item.quantity).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        ${item.quantity}
                    </td>
                `;
 
                cartItemsTableBody.appendChild(itemRow);
                totalPrice += item.quantity * item.price;
                productCount += parseInt(item.quantity);

            });

            cartCountElement.innerText = cart.length;
            cartTotalElement.innerText = `$${totalPrice.toFixed(2)}`;
            cartCountElement.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadCartData();
    });
</script>

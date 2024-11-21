<x-layouts.app :pageTitle="__('history')">
    <section class="grid grid-cols-1 md:grid-cols-3 m-5 dark:bg-gray-900 dark:text-white">

        <x-user.cart.items-table />

        <!-- Orders List Section -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg w-full  overflow-hidden">
            <div class="mx-auto flex  bg-gray-200 w-full">
                <h2 class="text-xl font-semibold p-4 ">{{ __('Orders') }}
                </h2>
                <x-dialogs.alert-clear-button :class="'px-4 py-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200'" :title="__('alert')" :message="__('itmDeleteMessage')" :buttonTxt="__('ClearAll')"
                    :confirmtxt="__('delete')" :canceltxt="__('cancel')" :id="'clear-all'">
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>

                    </div>
                </x-dialogs.alert-clear-button>
            </div>
            <!-- Orders List Section -->
            <table class=" min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                            {{ __('ID') }}</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                            {{ __('CustomerName') }}</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                            {{ __('CustomerAddress') }}</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                            {{ __('OrderTotalPrice') }}</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                            {{ __('CreatedAt') }}</th>
                    </tr>
                </thead>
                <tbody id="order-list" class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                    <!-- orders-->


                </tbody>
            </table>



        </div>

    </section>
    <script>
        function clearAllOrders() {
            localStorage.removeItem('orders'); // Remove the 'orders' item from local storage
            orderList.innerHTML = ''; // Clear the order list in the UI
            cartItemsContainer.innerHTML = ''; // Clear the order list in the UI
            const noOrdersMessage = document.createElement('li');
            noOrdersMessage.classList.add('p-4', 'text-center', 'text-gray-500');
            noOrdersMessage.textContent = 'No orders found.';
            orderList.appendChild(noOrdersMessage); // Show message if no orders
        }

        // Add event listener to the clear all button
        document.getElementById('clear-all').addEventListener('click', clearAllOrders);
    </script>
    <script>
        // Fetch orders from local storage
        const orders = JSON.parse(localStorage.getItem('orders')) || [];
        const orderList = document.getElementById('order-list');
        const cartItemsContainer = document.getElementById('cart-items2');
        let grandTotal = 0; // To accumulate the total price

        // Populate the order list
        if (orders.length > 0) {
            orders.forEach(orderData => {
                const order = orderData; // Directly access orderData
                const listItem = document.createElement('tr');
                listItem.classList.add('p-4', 'cursor-pointer', 'hover:bg-gray-100');
                let ccc = order.cart;
                //  <p class="font-semibold">Order ID: ${ JSON.stringify(cart)}</p>
                listItem.innerHTML = `
                        

                        <tr class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" id="main-row-${  order.id}">
                            <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">${  order.id}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">${  order.name}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">${  order.address}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $globalConfig->currency->sign }} ${order.totalPrice.toFixed(2)}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">${  order.date}</td>
                        </tr>
                            `;

                listItem.addEventListener('click', () => {
                    showOrderDetails(order);
                });

                orderList.appendChild(listItem);
            });
        } else {
            const noOrdersMessage = document.createElement('li');
            noOrdersMessage.classList.add('p-4', 'text-center', 'text-gray-500');
            noOrdersMessage.textContent = 'No orders found.';
            orderList.appendChild(noOrdersMessage);
        }

        // Function to show order details (including cart)
        function showOrderDetails(order) {
            const cart = order.cart; // Access the cart directly from the order
            cartItemsContainer.innerHTML = ''; // Clear previous cart details
            grandTotal = 0; // Reset grand total

            document.querySelectorAll('.total-price').forEach(function(element) {
                element.innerText = `{{ $globalConfig->currency->sign }} ${order.totalPrice.toFixed(2)}`;
            });
            cart.forEach(function(product) {

                let total = (product.price * product.quantity).toFixed(2);
                const imageUrl = "{{ url('storage') . '?img=' }}" + product.image ??
                    ''; // Ensure your images have this pattern

                let row = `
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    <img class="w-16 h-16 object-cover" src="${imageUrl}" alt="${product.title}">
                                </td>
                                 
                                <td class="border border-gray-300 px-4 py-2">${product.title}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $globalConfig->currency->sign }} ${product.price}</td>
                                <td class="border border-gray-300 px-4 py-2">${product.quantity}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $globalConfig->currency->sign }} ${total}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="/product?Pid=${product.id}" class="text-blue-500 hover:text-blue-700 font-bold">{{ __('show') }}</a>
                                </td>
                             
                            </tr>
                        `;
                cartItemsContainer.innerHTML += row;


            });

        }

        // Handle responsiveness - show list on small screens
        window.addEventListener('resize', () => {
            const orderDetails = document.getElementById('order-details');
            if (window.innerWidth >= 1024) {
                orderDetails.classList.remove('hidden');
            } else {
                orderDetails.classList.add('hidden');
            }
        });

        function deleteOrder(id) {
            const updatedOrders = orders.filter(order => order.id !== id); // Updated to access id directly
            localStorage.setItem('orders', JSON.stringify(updatedOrders));
            location.reload(); // Reload the page to update the order list
        }
    </script>

</x-layouts.app>

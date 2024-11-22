
<x-layouts.app :pageTitle="__('history')">
    <section class="grid grid-cols-1 md:grid-cols-3 m-5 dark:bg-gray-900 dark:text-white">
        <x-user.cart.items-table />

        <!-- Orders List Section -->
        <div class="overflow-x-auto bg-gray-200 dark:bg-gray-800 shadow-md rounded-lg w-full overflow-hidden">
            <div class="mx-auto flex w-full justify-between items-center">
                <h2 class="text-xl font-semibold p-4">{{ __('Orders') }}</h2>
                <x-dialogs.alert-clear-button 
                    class="px-4 py-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200"
                    :title="__('alert')" 
                    :message="__('itmDeleteMessage')" 
                    :buttonTxt="__('ClearAll')" 
                    :confirmtxt="__('delete')" 
                    :canceltxt="__('cancel')" 
                    id="clear-all">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                </x-dialogs.alert-clear-button>
            </div>

            <!-- Orders Table -->
            <table class="min-w-full mb-10 divide-y bg-gray-200 dark:bg-gray-800 divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        @foreach(['CustomerName', 'CustomerAddress', 'OrderTotalPrice', 'CreatedAt', 'ID'] as $header)
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 whitespace-nowrap">
                            {{ __($header) }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="order-list" class="divide-y divide-gray-200 bg-gray-100 dark:bg-gray-700 dark:divide-gray-600">
                    <!-- orders will be populated dynamically -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- JavaScript -->
    <script type="module">
        class OrderManager {
            constructor() {
                this.orders = JSON.parse(localStorage.getItem('orders')) || [];
                this.orderList = document.getElementById('order-list');
                this.cartItemsContainer = document.getElementById('cart-items2');
                this.init();
            }

            init() {
                this.populateOrderList();
                document.getElementById('clear-all').addEventListener('click', () => this.clearAllOrders());
            }

            clearAllOrders() {
                localStorage.removeItem('orders');
                this.orderList.innerHTML = this.createNoOrdersMessage();
                this.cartItemsContainer.innerHTML = '';
            }

            createNoOrdersMessage() {
                return `<div class="p-4 text-center text-gray-500 w-full">{{ __('No orders found.') }}</div>`;
            }

            populateOrderList() {
                if (this.orders.length === 0) {
                    this.orderList.innerHTML = this.createNoOrdersMessage();
                    return;
                }

                const fragment = document.createDocumentFragment();
                this.orders.forEach(order => {
                    const row = document.createElement('tr');
                    row.classList.add('cursor-pointer', 'hover:bg-gray-200', 'dark:hover:bg-gray-700');
                    row.innerHTML = `
                        <td class="px-4 py-4 text-center dark:text-gray-300">${order.name}</td>
                        <td class="px-4 py-4 text-center dark:text-gray-300">${order.address}</td>
                        <td class="px-4 py-4 text-center dark:text-gray-300">{{ $globalConfig->currency->sign }} ${order.totalPrice.toFixed(2)}</td>
                        <td class="px-4 py-4 text-center dark:text-gray-300">${order.date}</td>
                        <td class="px-4 py-4 text-center dark:text-gray-300">${order.id}</td>
                    `;
                    row.addEventListener('click', () => this.showOrderDetails(order));
                    fragment.appendChild(row);
                });

                this.orderList.appendChild(fragment);
            }

            showOrderDetails(order) {
                const { cart } = order;
                this.cartItemsContainer.innerHTML = cart.map(product => `
                    <tr>
                        <td class="border px-4 py-2">
                            <img class="w-16 h-16 object-cover" src="{{ url('storage') . '?img=' }}${product.image}" alt="${product.title}">
                        </td>
                        <td class="border px-4 py-2">${product.title}</td>
                        <td class="border px-4 py-2">{{ $globalConfig->currency->sign }} ${product.price}</td>
                        <td class="border px-4 py-2">${product.quantity}</td>
                        <td class="border px-4 py-2">{{ $globalConfig->currency->sign }} ${(product.price * product.quantity).toFixed(2)}</td>
                        <td class="border px-4 py-2">
                            <a href="/product?Pid=${product.id}" class="text-blue-500 hover:text-blue-700 font-bold">{{ __('show') }}</a>
                        </td>
                    </tr>
                `).join('');
            }
        }

        new OrderManager();
    </script>
</x-layouts.app>

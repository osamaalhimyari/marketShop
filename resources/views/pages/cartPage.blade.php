<x-layouts.app :pageTitle="'cart'">
    <section class="grid grid-cols-1 md:grid-cols-3 m-5 dark:bg-gray-900 dark:text-white">
        <x-user.cart.items-table />
        <x-dialogs.loadingMessage />
        <x-user.cart.order-Invoice />
    </section>
</x-layouts.app>

<script>
    document.addEventListener("DOMContentLoaded", initializeCart);

    function initializeCart() {
        const cartItemsContainer = document.getElementById('cart-items2');
        const buttonOfInvoice = document.getElementById('buttonOfInvoice');
        const cart = getCart();
        const grandTotal = calculateCart(cart, cartItemsContainer);

        updateCartSummary(cart, grandTotal);
        toggleInvoiceButton(buttonOfInvoice, cart.length > 0);

        document.getElementById('loadingMessage').addEventListener('click', closeLoadingMessage);
    }

    function getCart() {
        return JSON.parse(localStorage.getItem('cart')) || [];
    }

    function calculateCart(cart, container) {
        container.innerHTML = "";
        let grandTotal = 0;

        if (cart.length > 0) {
            cart.forEach(product => {
                const total = (product.price * product.quantity).toFixed(2);
                grandTotal += parseFloat(total);
                container.innerHTML += generateCartRow(product, total);
            });
        } else {
            container.innerHTML = '<tr><td colspan="5" class="text-center py-4">{{ __('cartIsEmpty') }}</td></tr>';
        }

        return grandTotal;
    }

    function generateCartRow(product, total) {
        const imageUrl = `{{ url('storage') . '?img=' }}${product.image || ''}`;
        return `
            <tr class="p-6">
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">
                    <img class="w-16 h-16 object-cover" src="${imageUrl}" alt="${product.title}">
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">${product.title}</td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">{{ $globalConfig->currency->sign }} ${product.price}</td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">${product.quantity}</td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">{{ $globalConfig->currency->sign }} ${total}</td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">
                    <button onclick="deleteFromCart('${product.id}')" class="text-red-500 hover:text-red-700 font-bold">{{ __('delete') }}</button>
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-4">
                    <a href="/product?Pid=${product.id}" class="text-blue-500 hover:text-blue-700 font-bold">{{ __('show') }}</a>
                </td>
            </tr>`;
    }

    function updateCartSummary(cart, total) {
        document.getElementById('summary-ProductsCount').innerText = cart.length;
        document.querySelectorAll('.total-price').forEach(el => {
            el.innerText = `{{ $globalConfig->currency->sign }} ${total.toFixed(2)}`;
        });
    }

    function toggleInvoiceButton(button, enabled) {
        button.disabled = !enabled;
        button.classList.toggle('bg-blue-600', enabled);
        button.classList.toggle('bg-gray-400', !enabled);
    }

    function clearCart() {
        localStorage.removeItem('cart');
        initializeCart(); // Refresh UI without reloading
    }

    function deleteFromCart(productId) {
        const cart = getCart().filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        initializeCart(); // Refresh UI without reloading
    }

    function closeLoadingMessage(event) {
        if (event.target.id === 'loadingMessage') {
            document.getElementById('loadingMessage').classList.add('hidden');
        }
    }

    async function submitOrder(event) {
        event.preventDefault();

        const loadingMessage = document.getElementById('loadingMessage');
        const loader = document.getElementById('loader');

        const iconContainer = document.getElementById('iconContainer');
        const message = document.getElementById('message');

        loadingMessage.classList.remove('hidden');
        loader.classList.remove('hidden');
        iconContainer.classList.add('hidden');

        const orderData = {
            name: document.getElementById('name').value,
            address: document.getElementById('address').value,
            cart: getCart(),
        };

        try {
            const response = await fetch("{{ route('order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(orderData)
            });

            if (!response.ok) throw new Error('Failed to submit order');

            const data = await response.json();
            saveOrder(data.order);
            clearCart();

            displaySuccessMessage(message, iconContainer, data.message);

        } catch (error) {
            displayErrorMessage(message, iconContainer, error.message);
        } finally {
            loader.classList.add('hidden');
        }
    }

    function saveOrder(order) {
        const orders = JSON.parse(localStorage.getItem('orders')) || [];
        orders.push(order);
        localStorage.setItem('orders', JSON.stringify(orders));
    }

    function displaySuccessMessage(messageEl, iconContainer, successMsg) {
        messageEl.innerText = `order has been sent successfully`;
        iconContainer.innerHTML = `
       <svg  class="icon   h-8 w-8 mx-auto mb-4" fill="#619f23" width="64px" height="64px" viewBox="-4.32 -4.32 44.64 44.64" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#619f23" stroke-width="0.00036"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.072"></g><g id="SVGRepo_iconCarrier"> <title>success-standard-solid</title> <path class="clr-i-solid clr-i-solid-path-1" d="M18,2A16,16,0,1,0,34,18,16,16,0,0,0,18,2ZM28.45,12.63,15.31,25.76,7.55,18a1.4,1.4,0,0,1,2-2l5.78,5.78L26.47,10.65a1.4,1.4,0,1,1,2,2Z"></path> <rect x="0" y="0" width="36" height="36" fill-opacity="0"></rect> </g></svg>
            `;
        iconContainer.classList.remove('hidden');
        setTimeout(() => document.getElementById('loadingMessage').classList.add('hidden'), 3000);
    }

    function displayErrorMessage(messageEl, iconContainer, errorMsg) {
        messageEl.innerText = `an there happend an Error try again later`;
        iconContainer.innerHTML =
            `
       <svg class="icon  h-16 w-16 mx-auto mb-4" fill="#e91616" width="100px" height="100px" viewBox="-8.96 -8.96 81.92 81.92" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" stroke="#e91616" stroke-width="0.00064"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect id="Icons" x="-704" y="-64" width="1280" height="800" style="fill:none;"></rect> <g id="Icons1" serif:id="Icons"> <g id="Strike"> </g> <g id="H1"> </g> <g id="H2"> </g> <g id="H3"> </g> <g id="list-ul"> </g> <g id="hamburger-1"> </g> <g id="hamburger-2"> </g> <g id="list-ol"> </g> <g id="list-task"> </g> <g id="trash"> </g> <g id="vertical-menu"> </g> <g id="horizontal-menu"> </g> <g id="sidebar-2"> </g> <g id="Pen"> </g> <g id="Pen1" serif:id="Pen"> </g> <g id="clock"> </g> <g id="external-link"> </g> <g id="hr"> </g> <g id="info"> </g> <g id="warning"> </g> <path id="error-circle" d="M32.085,56.058c6.165,-0.059 12.268,-2.619 16.657,-6.966c5.213,-5.164 7.897,-12.803 6.961,-20.096c-1.605,-12.499 -11.855,-20.98 -23.772,-20.98c-9.053,0 -17.853,5.677 -21.713,13.909c-2.955,6.302 -2.96,13.911 0,20.225c3.832,8.174 12.488,13.821 21.559,13.908c0.103,0.001 0.205,0.001 0.308,0Zm-0.282,-4.003c-9.208,-0.089 -17.799,-7.227 -19.508,-16.378c-1.204,-6.452 1.07,-13.433 5.805,-18.015c5.53,-5.35 14.22,-7.143 21.445,-4.11c6.466,2.714 11.304,9.014 12.196,15.955c0.764,5.949 -1.366,12.184 -5.551,16.48c-3.672,3.767 -8.82,6.016 -14.131,6.068c-0.085,0 -0.171,0 -0.256,0Zm-12.382,-10.29l9.734,-9.734l-9.744,-9.744l2.804,-2.803l9.744,9.744l10.078,-10.078l2.808,2.807l-10.078,10.079l10.098,10.098l-2.803,2.804l-10.099,-10.099l-9.734,9.734l-2.808,-2.808Z"></path> <g id="plus-circle"> </g> <g id="minus-circle"> </g> <g id="vue"> </g> <g id="cog"> </g> <g id="logo"> </g> <g id="radio-check"> </g> <g id="eye-slash"> </g> <g id="eye"> </g> <g id="toggle-off"> </g> <g id="shredder"> </g> <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g> <g id="react"> </g> <g id="check-selected"> </g> <g id="turn-off"> </g> <g id="code-block"> </g> <g id="user"> </g> <g id="coffee-bean"> </g> <g id="coffee-beans"> <g id="coffee-bean1" serif:id="coffee-bean"> </g> </g> <g id="coffee-bean-filled"> </g> <g id="coffee-beans-filled"> <g id="coffee-bean2" serif:id="coffee-bean"> </g> </g> <g id="clipboard"> </g> <g id="clipboard-paste"> </g> <g id="clipboard-copy"> </g> <g id="Layer1"> </g> </g> </g></svg>      `;
        iconContainer.classList.remove('hidden');
    }
</script>

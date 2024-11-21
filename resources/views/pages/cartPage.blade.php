<x-layouts.app :pageTitle="'theCart'">


    <section class="grid grid-cols-1 md:grid-cols-3 m-5 dark:bg-gray-900 dark:text-white">

        <x-user.cart.items-table />
        <x-dialogs.loadingMessage />
        <x-user.cart.order-Invoice />
        <p id="message" class="text-gray-700">Submitting your order, please wait...</p>
    </section>





</x-layouts.app>




<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartItemsContainer = document.getElementById('cart-items2');
    let buttonOfInvoice = document.getElementById('buttonOfInvoice');
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('loadingMessage').addEventListener('click', (event) => {
            if (event.target === document.getElementById('loadingMessage')) {
                document.getElementById('loadingMessage').classList.add('hidden');
            }
        });


        const ProductsCount = document.getElementById('summary-ProductsCount');
        ProductsCount.innerText = cart.length ?? 0;
        let grandTotal = 0; // Initialize grand total

        // Retrieve cart items from localStorage
        if (cart.length > 0) {
            cart.forEach(function(product) {
                const imageUrl = "{{ url('storage') . '?img=' }}" + product.image ?? '';
                let total = (product.price * product.quantity).toFixed(2);
                grandTotal += parseFloat(total); // Accumulate the total price

                let row = `
                    <tr class="p-6">
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4">
                           <img class="w-16 h-16 object-cover" src="${imageUrl}" alt="${product.title}">
                        </td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4">${product.title}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 whitespace-nowrap w-full">{{ $globalConfig->currency->sign }} ${product.price}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4">${product.quantity}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 whitespace-nowrap w-full">{{ $globalConfig->currency->sign }} ${total}</td>
                        <td class="border  border-gray-300 dark:border-gray-500 px-4 py-4 mr-3 ml-3" > 
                            <a href="/product?Pid=${product.id}" class="text-blue-500 hover:text-blue-700   font-bold">{{ __('show') }}</a>
                            <span class="p-3"></span>
                            <button onclick="deleteFromCart('${product.id}')" class="text-red-500 hover:text-red-700   font-bold">{{ __('delete') }}</button> 
                            </td>
                    </tr>
                `;

                cartItemsContainer.innerHTML += row;
            });

            // Update the total price in the footer
            document.querySelectorAll('.total-price').forEach(function(element) {
                element.innerText = `{{ $globalConfig->currency->sign }} ${grandTotal.toFixed(2)}`;
            });

            buttonOfInvoice.disabled = false; // Enable the button
            buttonOfInvoice.classList.remove('bg-gray-400'); // Optional: Change styles
            buttonOfInvoice.classList.add('bg-blue-600');
        } else {
            buttonOfInvoice.disabled = true; // Disable the button
            buttonOfInvoice.classList.remove('bg-blue-600');
            buttonOfInvoice.classList.add('bg-gray-400');

            cartItemsContainer.innerHTML =
                '<tr><td colspan="5" class="text-center py-4">{{ __('cartIsEmpty') }}</td></tr>';
        }
    });



    function clearCart() {
        localStorage.removeItem('cart');
        cartItemsContainer.innerHTML = '<tr><td colspan="5" class="text-center py-4">{{ __('cartIsEmpty') }}</td></tr>';
        //    location.reload();
    }

    function getCartData() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        alert(JSON.stringify(cart, null, 2)); // `null` for replacer, `2` for pretty-printing
    }


    function deleteFromCart(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Filter out the product to be deleted
        cart = cart.filter(item => item.id !== productId);

        // Update the cart in local storage
        localStorage.setItem('cart', JSON.stringify(cart));

        location.reload();
    }

    function saveOrder(order) {
        // Retrieve existing orders from localStorage or initialize an empty array
        const orders = JSON.parse(localStorage.getItem('orders')) || [];

        // Add the new order to the array
        orders.push(order);

        // Save the updated orders array back to localStorage
        localStorage.setItem('orders', JSON.stringify(orders));
    }
</script>

<script>
    function submitOrder(event) {
        event.preventDefault(); // Prevent default form submission
        const loadingMessage = document.getElementById('loadingMessage');

        loadingMessage.classList.remove('hidden'); // Show loading message
        document.getElementById('iconContainer').classList.add('hidden'); // Hide icon container
        document.getElementById('loader').classList.remove('hidden'); // Show loader spinner

        // Retrieve form data
        const name = document.getElementById('name').value;
        const address = document.getElementById('address').value;
        let cart = JSON.parse(localStorage.getItem('cart')) || []; // Get cart data from local storage

        // Prepare data to send
        const orderData = {
            name: name,
            address: address,
            cart: cart,
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send the data using fetch
        fetch("{{ route('order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(orderData), // Send order data as JSON
            })
            .then(response => {
                if (!response.ok) {
                    new Error('Network response was not ok');
                }
                return response.json(); // Parse the JSON response
            })
            .then(data => {
                // Hide the loader and show success message
                saveOrder(data.order)
                clearCart();
                document.getElementById('loader').classList.add('hidden'); // Hide loader
                const successIcon = document.getElementById('successIcon');
                const iconContainer = document.getElementById('iconContainer');
                iconContainer.classList.remove('hidden');
                successIcon.classList.remove('hidden');
                document.getElementById('message').innerText = `Success: ${data.message}`;
                setTimeout(() => loadingMessage.classList.add('hidden'), 3000); // Auto hide after 3 seconds
                location.reload();
            })
            .catch(error => {
                // Hide the loader and show error message
                document.getElementById('loader').classList.add('hidden'); // Hide loader
                const errorIcon = document.getElementById('errorIcon');
                const iconContainer = document.getElementById('iconContainer');
                iconContainer.classList.remove('hidden');
                errorIcon.classList.remove('hidden');
                document.getElementById('message').innerText = `Error: ${error.message}`;

            });
    }
</script>

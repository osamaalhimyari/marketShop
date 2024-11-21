
<div class="detail-extralink mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg" dir="rtl">
    <form onsubmit="event.preventDefault(); addToCart();" class="space-y-4">
        <!-- Quantity Selector -->
        <label for="quantity">{{__('addToCartTips')}}:</label>
        <div class="flex items-center space-x-1">
            <!-- Decrease Button -->
            <button type="button" 
                    class="minus w-10 h-10 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-900 rounded-r-lg flex items-center justify-center hover:bg-gray-300 transition-all" 
                    onclick="decreaseValue()">
                    <span class="text-xl text-white dark:text-gray-800">-</span>
            </button>
            
            <!-- Quantity Input -->
            <input id="quantity" name="quantity" type="text" 
                   value="1" 
                   class="w-16 h-10 text-center bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 font-medium border border-gray-300 dark:border-gray-600" 
                   min="1" max="{{ $product->quantity }}" 
                   disabled oninput="this.value = this.value.replace(/[^0-9]/g, '0');" />
            
            <!-- Increase Button -->
            <button type="button" 
                    class="plus w-10 h-10 bg-gray-800 dark:bg-gray-200 text-gray-700 dark:text-gray-900 rounded-l-lg flex items-center justify-center hover:bg-gray-300 transition-all" 
                    onclick="increaseValue()">
                    <span class="text-xl text-white dark:text-gray-800">+</span>
            </button>
        </div>

        <!-- Add to Cart Button -->
        <div>
            <button type="submit" 
                    class="w-full py-3 text-lg font-semibold {{ $product->quantity < 1 ? 'bg-gray-300 text-gray-600 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700 focus:outline-none rounded-lg transition duration-200' }}" 
                    {{ $product->quantity < 1 ? 'disabled' : '' }}>
                {{ __('AddToCart') }}
            </button>
        </div>
    </form>
</div>

{{--  --}}
<script>
    function addToCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let product = {
            id: "{{ sha1($product->id )}}",
            title: "{{ $product->title }}",
            price: "{{ $product->price }}",
            quantity: document.getElementById('quantity').value,
            image: "{{ $product->product_images->first()->imagePath??"" }}"
        };
        let existingProductIndex = cart.findIndex(item => item.id === product.id);
        if (existingProductIndex !== -1) {
            cart[existingProductIndex].quantity = parseInt(cart[existingProductIndex].quantity) + parseInt(product.quantity);
        } else {
            cart.push(product);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        window.location.href = '/cart';
    }
    function decreaseValue() {
        let quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    }
    function increaseValue() {
        let quantityInput = document.getElementById('quantity');
        let maxQuantity = parseInt(quantityInput.getAttribute('max'));
        let quantity = parseInt(quantityInput.value);
        if (quantity < maxQuantity) {
            quantityInput.value = quantity + 1;
        }
    }
</script>

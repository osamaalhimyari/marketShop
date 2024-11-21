<div class="detail-gallery">
    <div class="relative">
        <span class="zoom-icon absolute top-2 right-2 text-gray-500 dark:text-white"><i
                class="fi-rs-search"></i></span>
        <div class="product-image-slider">

            <figure class="rounded-lg overflow-hidden shadow-lg bg-white">
                <!-- Large image display -->
                <div class="mb-4">
                    <img id="selectedImage"
                        src="{{ url('storage') . '?img=' . ($product->product_images->first()->imagePath??"") }}"
                        alt="Selected Product image"
                        class="object-cover object-center w-full h-100 rounded-md shadow-lg transition-transform duration-200"
                        loading="lazy">
                </div>

                <!-- Thumbnail grid -->
                <div class="overflow-y-scroll bg-gray-200 p-2"
                    style="height: 300px; scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        /* Hide scrollbar for webkit browsers */
                        .overflow-y-scroll::-webkit-scrollbar {
                            display: none;
                            /* Hide scrollbar for Chrome, Safari and Opera */
                        }
                    </style>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($product->product_images as $image)
                            <div class="relative h-full cursor-pointer"
                                onclick="changeImage('{{ url('storage') . '?img=' . ($image->imagePath) }}')">
                                <img src="{{ url('storage') . '?img=' . ($image->imagePath) }}"
                                    alt="Product image"
                                    class="object-cover object-center w-full h-full rounded-md shadow-lg transition-transform duration-200 hover:scale-105"
                                    loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>
            </figure>

            <script>
                function changeImage(src) {
                    // Change the source of the selected image
                    document.getElementById('selectedImage').src = src;
                }
            </script>

        </div>
    </div>
</div>
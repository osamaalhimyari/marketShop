<x-layouts.app :pageTitle="$product->title" :pageHeadLine="$product->headLine" :pageDescription="$product->description" :pagekeywords="$product->category->name, $product->price" :imageUri="url('storage') . '?img=' . ($product->product_images->first()->imagePath ?? '')">

    <section class="m-5 dark:bg-black dark:text-white">

        {{-- <div class="container mx-auto"> --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 ">
            <div class="col-span-2">
                @if (Auth::check())
                    <x-user.viewProduct.options-nav :product="$product" />
                @endif
                <div class="product-detail bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
                        <x-user.viewProduct.images :product="$product" />
                        <x-user.viewProduct.info :product="$product">
                            <x-user.viewProduct.AddToCartForm :product="$product" />
                        </x-user.viewProduct.info>
                    </div>
                </div>
            </div>
            <x-user.viewProduct.discription :product="$product" />

        </div>
        {{-- </div> --}}
        <x-user.viewProduct.suggestedList :products="$products" />
    </section>
</x-layouts.app>
<!-- -->

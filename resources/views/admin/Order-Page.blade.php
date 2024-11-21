<x-layouts.app :pageTitle="'cart'">


    <section class="grid grid-cols-1 md:grid-cols-3 m-5 dark:bg-gray-900 dark:text-white">

        <x-admin.cart.items-table :order=$order />
        <x-admin.cart.order-Invoice :order=$order />

    </section>
</x-layouts.app>

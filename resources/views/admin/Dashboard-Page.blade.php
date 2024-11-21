
<x-layouts.app :pageTitle="__('dashboard')">  
    <div class="content-wrapper p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Categories Card -->
            <x-admin.dashboard.Summary-Card :data=$categories  :title="__('TotalCate')"/>
            <!-- Total Products Card -->
            <x-admin.dashboard.Summary-Card :data=$products  :title="__('TotalProducts')"/>
            <!-- Total Orders Card -->
            <x-admin.dashboard.Summary-Card :data=$orderData  :title="__('TotalOrders')"/>
        </div>
    
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Products per Category Chart -->
            <x-admin.dashboard.products-per-category-chart :categories="$categories" />
            <!-- Sales Overview Chart -->
            <x-admin.dashboard.Sales-Overview-Chart :orders="$orderData" :orderData="$orderData" />
        </div>
        <div>
            <x-admin.dashboard.incoming-orders-list :orders="$orders" />
        </div>
    </div>
    
   
</x-layouts.app>

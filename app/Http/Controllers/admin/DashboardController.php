<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
   


    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        $orders = Order::all();
        $orderData = Order::selectRaw('status, COUNT(*) as count, SUM(total_price) as total_sales')
        ->groupBy('status')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->status => [
                'count' => $item->count,
                'total_sales' => $item->total_sales,
            ]];
        })
        ->toArray();
    
        return view('admin.Dashboard-Page', compact('categories', 'products', 'orders', 'orderData'));
    }
}
// admin.Dashboard-Page
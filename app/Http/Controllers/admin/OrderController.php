<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request)
    {
        $orderId = $request->input('orderid');
        $status = $request->input('status');
    
        // Logic to update the order status
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status; // Update status as per your logic
            $order->save();
            return redirect()->back()->with('success', 'Order status updated successfully.');
        }
    
        return redirect()->back()->with('error', 'Order not found.');
    }
    public function getCartData(Request $request)
    {
        $orderId = $request->input('orderid');
    
        // Logic to update the order status
        // $order = Order::find($orderId)->carts();
        $order = Order::with([
            'carts.product.product_images' => function ($query) {
                $query->limit(1); // Fetch only one image per product
            }
        ])->findOrFail($orderId);
        if ($order) {
            return view('admin.Order-Page', compact('order'));
        }
    
        return redirect()->back()->with('error', 'Order not found.');
    }



}

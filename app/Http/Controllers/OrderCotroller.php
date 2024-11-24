<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderCotroller extends Controller
{
   

function storeOrder(Request $request) {
    if (count($request->cart) < 1) {
        return response()->json(['message' => 'empty cart'], 404);
    }

    // Extract product IDs from cart
    $productIds =collect($request->cart)->pluck('id')->toArray();
    //  array_column($request->cart, 'id');  // Using array_column instead of collect->pluck

    // Fetch all products in a single query
    // $products = Product::whereIn(DB::raw('sha1(id)'), $productIds)->get()->keyBy('id');  // Key products by ID to avoid searching in the collection

    $products = Product::whereIn(DB::raw('sha1(id)'), $productIds)  // Match the hashed values
    ->get()
    ->keyBy(function ($product) { 
        return sha1($product->id);  // Hash the product's ID to match the cart's IDs
    }); 
// If some products are missing, return an error
    if (count($products) !== count($productIds)) {
        return response()->json(['message' => 'Some products not found.'], 404);
    }

    // Calculate the total price efficiently
    $totalPrice = 0;
    foreach ($request->cart as $cartItem) {
        $product = $products[$cartItem['id']];  // Retrieve product from pre-loaded collection
        $totalPrice += $product->price * $cartItem['quantity'];
    }

    // Create the order with the total price
    $order = Order::create([
        'name' => $request->name ?? '',
        'address' => $request->address ?? '',
        'total_price' => $totalPrice,
        'status' => 0,
        'approved_by' => 1
    ]);

    // Prepare the cart items for insertion
    $cartEntries = [];
    foreach ($request->cart as $cartItem) {
        $product = $products[$cartItem['id']];  // Retrieve product from pre-loaded collection
        $cartEntries[] = [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $cartItem['quantity'],
            'item_total_price' => $product->price * $cartItem['quantity'],
        ];
    }

    // Bulk insert cart entries to minimize queries
    Cart::insert($cartEntries);

    return response()->json([
        'message' => 'Order submitted successfully',
        "order" => [
            "id" => sha1($order->id),
            "name" => $order->name,
            "address" => $order->address,
            "date" => $order->created_at->format('Y-m-d H:i:s'),
            "totalPrice" => $order->total_price,
            "cart" => $request->cart
        ]
    ]);
}

}

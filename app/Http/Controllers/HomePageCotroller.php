<?php

namespace App\Http\Controllers;

use App\Filters\V1\CategoryFilter;
use App\Models\Category;
use App\Models\Config;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class HomePageCotroller extends Controller
{


public function getAllProducts(Request $request)
{


 
if ($request->user() && !($request->path()=="/")) {
 return   redirect('/admin');
}


$configs=Config::first();
    // Fetch all categories
    $categories = Category::all();

    // Get the selected category ID from the request or default to 'all'
    $selectedCategoryId = $request->input('catid', 'all');
    $querySearch = $request->input('text');
    $searchTxt =null;
    // Determine which query to use based on category selection
    $query = Product::query();

    if ($selectedCategoryId !== 'all') {
        $selectedCategory = Category::find($selectedCategoryId);

        if (!$selectedCategory) {
            return redirect("/");
        }

        $query = $selectedCategory->products();
    }

    // Apply search filter if querySearch is not null
    $productsQ = $query->where('published', 1);

    if ($querySearch != null) {
        $productsQ = $productsQ->where(function ($queryTxt) use ($querySearch) {
            $queryTxt->where('title', 'like', "%{$querySearch}%")
                     ->orWhere('description', 'like', "%{$querySearch}%");
        });
        $searchTxt=$querySearch;
    }

    // Fetch products with additional filters and sorting
    $products = $productsQ
        ->with([
            'category',
            'product_images' => function ($query) {
                $query->limit(1); // Limit to one image per product
            }
        ])
        ->filtered()
        ->orderByRaw("LOG(LEAST(GREATEST(views, 1), 1000)) + UNIX_TIMESTAMP(updated_at) / 1000000 DESC")
        ->paginate(10)
        ->withQueryString();

    return view('pages.HomePage', compact('categories', 'selectedCategoryId', 'products' , 'searchTxt' ,));
}

public function getProduct(Request $request) {
    $productId = $request->input('Pid');

    // Find the product, either by the raw sha1 or direct id
    $product = Product::whereRaw('sha1(id) = ? OR id = ?', [$productId, $productId])->first();

    if ($product) {
        // Eager load related data like category (if needed)
        $primaryCategoryProducts = Product::where('category_id', $product->category_id)
            ->where('published', 1)
            ->where('quantity', '>', 0)
            ->orderByDesc('updated_at')  // Prioritize the newest
            ->orderBy('price')           // Then order by price
            ->orderByDesc('discount')    // And discount
            ->limit(5)                   // Limit to 5 products
            ->get();

        // Get 5 products from other categories (1 per category), optimized to avoid distinct()
        $otherCategoryProducts = Product::where('category_id', '!=', $product->category_id)
            ->where('published', 1)
            ->where('quantity', '>', 0)
            ->orderByDesc('updated_at')   // Prioritize the newest
            ->orderBy('price')            // Then order by price
            ->orderByDesc('discount')     // And discount
            ->take(5)                     // Limit to 5 products
            ->get();

        // Combine the two sets of products
        $products = $primaryCategoryProducts->merge($otherCategoryProducts);

        // Increment the view count of the current product
        $product->increment('views');

        // Return the view with product data
        return view('pages.ShowProductPage', compact('product', 'products'));
    } else {
        return redirect("/");
    }
}

}

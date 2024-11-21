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
            $queryTxt->where('title', 'like', "%{}%")
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

public function getProduct( Request $request){
    $productId = $request->input('Pid');
    // sha1()
    // $product = Product::find($productId);
    $product = Product::whereRaw('sha1(id) = ? OR id=? ', [$productId, $productId])->first();
    if($product){
        // 
        $primaryCategoryProducts = Product::where('category_id', $product->category_id)
        ->where('published', 1)
        ->where('quantity', '>', 0)
        ->orderByDesc('updated_at')
        ->orderBy('price')
        ->orderByDesc('discount')
        ->take(5);

    // Get 5 products from other categories (1 per category)
    $otherCategoryProducts = Product::where('category_id', '!=', $product->category_id)
        ->where('published', 1)
        ->where('quantity', '>', 0)
        ->orderByDesc('updated_at')
        ->orderBy('price')
        ->orderByDesc('discount')
        ->distinct('category_id')  // Ensure distinct categories
        ->take(5);  // Limit to 5 products
    $combinedProducts = $primaryCategoryProducts->union($otherCategoryProducts);
    $products = $combinedProducts->get();
        $product->increment('views');
        return view('pages.ShowProductPage',compact('product','products'));
    }else{
        return redirect("/");
    }
       }

}

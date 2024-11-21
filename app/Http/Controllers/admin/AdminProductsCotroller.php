<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mayank\Alert\Alert;
class AdminProductsCotroller extends Controller
{




    public function getProduct(Request $request)
    {
       $productId  = $request->input('Pid');
       $categories = Category::all();
       $currencies = Currency::all();
        if(! $productId){
            $product = new Product();
            return view('admin.Add-Product-Page', compact('product', 'categories' , 'currencies'));
        }else{
            $product = Product::find($productId);

                return view('admin.Edit-Product-Page', compact('product', 'categories' , 'currencies'));
            }
    }


    public function addProduct(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'headline' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'discount' => 'required|integer|min:0|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'currency_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff,heif,heic,raw|max:4048',

        ]);
    
        
        DB::beginTransaction();
    
        try {
            $product = $id ? Product::findOrFail($id) : new Product();
            $product->title = $request->title;
            $product->headLine = $request->headline;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->discount = $request->discount;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->currency_id = $request->currency_id;
            $product->published = $request->has('published');
            $product->save();
    
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // $path = $image->store('images', 'public');
                    $uniqueName = uniqid() . '_' . $image->getClientOriginalName();
                    $path = 'images/' . $uniqueName;
                    Storage::disk('public')->putFileAs('images', $image, $uniqueName);
                    Log::info('Uploading image with filename: ' . $path);
    
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->imagePath = $path;
                    $productImage->save();
                }
            }
    
            DB::commit();
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to save product and images: " . $e->getMessage());
             Alert::failure()->title('error!')->description('Failed to add product. Please try again.')->create();
            return redirect()->back();
        }
    
        Alert::success()->title('Success!')->description('Product saved successfully')->create();
            // return redirect()->back();
            return redirect()->route('admin-controll-Products');
    }
    
    
    public function getAllProducts()
    {

        // $products = Product::orderBy('updated_at', 'DESC')->get();

        $query = Product::with('category', 'product_images');
        $countProducts =  $query->count();
        $products =  $query->filtered()
            // ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(9)
            ->withQueryString();
        // $p=
        if ($products) {


            return view('admin.Products-Page', compact('products', 'countProducts'));
        } else {
            return redirect("/");
        }
    }

    public function deleteProduct(Request $request)
    {
        $productId = $request->input('Pid');
        $product = Product::find($productId);

        if ($product) {
            $product->delete();

            Alert::success()->title('Success!')->description('Product was successfully deleted.')->create();
        } else {
            Alert::failure()->title('Error!')->description('Something went wrong or product not found')->create();
        }

        return redirect()->back(); // Redirect after setting flash messages
    }



    // new 

    // // Update product details
    public function updateProduct(UpdateProductRequest $request)
    {


        $productId = $request->input('Pid');
        $product = Product::find($productId);
        $product->title = $request->input('title');
        $product->headline = $request->input('headline');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->discount = $request->input('discount');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->currency_id = $request->input('currency_id');
        $product->published = $request->input('published') ? 1 : 0;

        // Save images if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public'); // Save to public storage
                $product->product_images()->create(['imagePath' => $imagePath]); // Assuming a relationship exists
            }
        }

        $product->save(); // Save product details

        
        
        Alert::success()->title('Success!')->description('Product updated successfully!!!')->create();
        return redirect()->back();
    }

    
      

    // Delete image (this would need to be implemented)
    public function deleteImage(Request $request)
    {
        $img=$request->input('img');
        $image = ProductImage::find($img);
    
        if ($image) {
            // Delete the image file if necessary
            Storage::delete('public/' . $image->imagePath);
    
            $image->delete();

     
            Alert::success()->title('Success!')->description('Image deleted successfully!!!')->create();
            return redirect()->back();
        }
        Alert::failure()->title('Error!')->description('Something went wrong or Image not found')->create();

        return redirect()->back();
    }
    public function uploadImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff,heif,heic,raw|max:4048',
    ]);
    
    $image = $request->file('image');
    $path = $image->store('images', 'public');

    return response()->json(['path' => $path], 200);
}
}

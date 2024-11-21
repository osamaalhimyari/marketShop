<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product; // Assuming your products are in the Product model
use Illuminate\Support\Facades\Response;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    public function index()
    {
       
        $domain = 'https://electronicshop.kesug.com';

        $sitemap = SitemapGenerator::create($domain)
            ->getSitemap()
            ->add(Url::create("$domain/")
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0))
        
            // Add HTTPS version explicitly if necessary
            ->add(Url::create($domain)
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0))
        
            ->add(Url::create("$domain/cart")
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
        
            ->add(Url::create("$domain/login")
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        
        // Add dynamic product URLs
        $products = Product::orderBy('updated_at', 'DESC')->get();
        foreach ($products as $product) {
            $sitemap->add(Url::create("$domain/product?Pid=" . $product->id)
                ->setLastModificationDate($product->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.5));
        }
        
        // Add dynamic category URLs
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->add(Url::create("$domain/?catid=" . $category->id)
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.3));
        }
        
        // Get sitemap content as XML and return it as a response
        $xmlContent = $sitemap->render();
        
        return Response::make($xmlContent, 200, [
            'Content-Type' => 'application/xml',
        ]);
           }
}

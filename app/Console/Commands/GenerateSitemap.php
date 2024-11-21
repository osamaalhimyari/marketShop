<?php
namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Product;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate a sitemap file';

  
    // public function handle()
    // {
    //     // Create a new sitemap instance with your actual domain
    //     $sitemap = SitemapGenerator::create('https://127.0.0.1')
    //         ->getSitemap()
    //         ->add(Url::create('/')
    //             ->setLastModificationDate(now())
    //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
    //             ->setPriority(1.0)) // Set priority to 1.0 for homepage
    
    //         ->add(Url::create('/cart')
    //             ->setLastModificationDate(now())
    //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    //             ->setPriority(0.8)) // Set priority for cart
    
    //         ->add(Url::create('/homePage')
    //             ->setLastModificationDate(now())
    //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    //             ->setPriority(0.8)); // Set priority for homePage
    
    //     // Add dynamic product URLs
    //     $products = Product::orderBy('updated_at', 'DESC')->get();
    //     foreach ($products as $product) {
    //         $sitemap->add(Url::create('/product?Pid=' . $product->id)
    //             ->setLastModificationDate($product->updated_at)
    //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    //             ->setPriority(0.5)); // Set priority for products
    //     }
    
    //     // Add dynamic category URLs
    //     $categories = Category::all();
    //     foreach ($categories as $category) {
    //         $sitemap->add(Url::create('/?catid=' . $category->id)
    //             ->setLastModificationDate(now())
    //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
    //             ->setPriority(0.3)); // Set priority for categories
    //     }
    
    //     // Save the sitemap to the public directory
    //     $sitemap->writeToFile(public_path('sitemap.xml'));
    
    //     $this->info('Sitemap generated successfully!');
    // }
    public function handle()
    {
    // Create a new sitemap instance with your actual domain
$sitemap = SitemapGenerator::create('http://127.0.0.1') // HTTP version
->getSitemap()
->add(Url::create('/')
    ->setLastModificationDate(now())
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
    ->setPriority(1.0))

// Add HTTPS version
->add(Url::create('https://127.0.0.1')
    ->setLastModificationDate(now())
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
    ->setPriority(1.0))

->add(Url::create('/cart')
    ->setLastModificationDate(now())
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    ->setPriority(0.8))

->add(Url::create('/login')
    ->setLastModificationDate(now())
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    ->setPriority(0.8));

// Add dynamic product URLs
$products = Product::orderBy('updated_at', 'DESC')->get();
foreach ($products as $product) {
$sitemap->add(Url::create('/product?Pid=' . $product->id)
    ->setLastModificationDate($product->updated_at)
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    ->setPriority(0.5));
}

// Add dynamic category URLs
$categories = Category::all();
foreach ($categories as $category) {
$sitemap->add(Url::create('/?catid=' . $category->id)
    ->setLastModificationDate(now())
    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
    ->setPriority(0.3));
}

// Save the sitemap to the public directory
$sitemap->writeToFile(public_path('sitemap.xml'));

$this->info('Sitemap generated successfully!');

    }

    // public function handle()
    // {
    //     // Create a new sitemap instance
    //     $sitemap = Sitemap::create(); // Replace with your actual domain

    //     // Add static URLs
    //     $sitemap->add(url('/'));
    //     $sitemap->add(url('/cart'));
    //     $sitemap->add(url('/homePage'));

    //     // Add dynamic product URLs
    //     $categories = Category::all();
    //     foreach ($categories as $category) {
    //         $sitemap->add(url('/?catid=' . $category->id));
    //     }
    //     $products = Product::orderBy('updated_at', 'DESC')->get();
    //     foreach ($products as $product) {
    //         $sitemap->add(url('/product?Pid=' . $product->id));
    //     }

    //     // Save the sitemap to the public directory
    //     $sitemap->writeToFile(public_path('sitemap.xml'));

    //     $this->info('Sitemap generated successfully!');
    // }
}

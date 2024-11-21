<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
      $this->  product();
    }






    public function product()
    {
        // Initialize Faker with Arabic locale
        $faker = Faker::create('ar');

        $products = [
            [
                'title' => 'هاتف ذكي',
                'headLine' =>'هاتف محمول بسيط مع بطارية تدوم طويلاً.',
                'description' => 'هاتف ذكي عالي الجودة بشاشة عرض كاملة بحجم 6.5 إنش، يمتاز بألوان غنية وسطوع عالٍ حتى تحت ضوء الشمس.\n' .
                                 'مزود بمعالج ثماني النواة وذاكرة وصول عشوائي بسعة 8 جيجابايت، ما يجعله مثاليًا لتشغيل التطبيقات الثقيلة والألعاب دون أي تأخير.\n' .
                                 'يحتوي على بطارية ضخمة تدوم ليومين، بالإضافة إلى تقنية الشحن السريع التي توفر لك تجربة استخدام مستمرة طوال اليوم.',
                'quantity' => 50,
                'price' => 999.99,
                'imagePath' =>  "phone-",     
                'category_id' => 1,
                'published' => 1
            ],
            [
                'title' => 'لابتوب الألعاب',
                'headLine'=> 'شاشة كمبيوتر بدقة عالية وألوان واضحة.',
                'description' => 'لابتوب مخصص للألعاب مزود بمعالج i7 من الجيل العاشر وبطاقة رسومات NVIDIA GeForce RTX 3060.\n' .
                                 'يأتي بشاشة عرض بحجم 15.6 إنش بدقة 1080p ومعدل تحديث 144Hz، ما يوفر تجربة ألعاب سلسة وواضحة.\n' .
                                 'يحتوي على نظام تبريد متقدم يضمن لك أداءً مثاليًا حتى أثناء الجلسات الطويلة والمكثفة.',
                'quantity' => 30,
                'price' => 2999.99,
                'imagePath' =>   "computer-",
                'category_id' => 2,
                'published' => 1
            ],
            [
                'title' => 'ساعة ذكية',
                'headLine' => 'ساعة ذكية مقاومة للماء مع مميزات تتبع اللياقة البدنية.',
                'description' => 'ساعة ذكية مقاومة للماء مع مميزات تتبع اللياقة البدنية، بما في ذلك قياس معدل ضربات القلب والنوم.\n' .
                                 'مزودة بشاشة OLED عالية الوضوح، مما يتيح لك رؤية الإشعارات والرسائل بوضوح حتى في ضوء النهار الساطع.\n' .
                                 'تدعم الشحن اللاسلكي وتدوم بطاريتها لمدة 7 أيام بشحنة واحدة، مما يجعلها مثالية للاستخدام اليومي المكثف.',
                'quantity' => 100,
                'price' => 199.99,
                'imagePath' => "smartwatch-",
                'category_id' => 5,
                'published' => 1
            ],
            [
                'title' => 'سماعات ',
                'headLine' =>'سماعات رأس عالية الجودة للصوت النقي والجهير القوي.',
                'description' => 'سماعات  بجودة صوت استثنائية وإلغاء الضوضاء النشط، مما يتيح لك الاستمتاع بصوت نقي في البيئات الصاخبة.\n' .
                                 'مصممة بتقنية Bluetooth 5.0 لتحسين استقرار الاتصال وتقليل استهلاك الطاقة.\n' .
                                 'تدوم بطاريتها حتى 24 ساعة من التشغيل المتواصل، مع علبة شحن محمولة تمد البطارية بسرعة.',
                'quantity' => 200,
                'price' => 149.99,
                'imagePath' => "headphone-",
                'category_id' => 3,
                'published' => 1
            ],
            [
                'title' => 'كاميرا احترافية',
                'headLine' => 'كاميرا لاسلكية مع تسجيل فيديو عالي الجودة.',
                'description' => 'كاميرا احترافية عالية الدقة لالتقاط الصور والفيديوهات بجودة 4K، مع إمكانية التصوير في ظروف الإضاءة المنخفضة.\n' .
                                 'تحتوي على نظام تركيز تلقائي سريع ودقيق لتصوير لحظات الحركة بوضوح تام.\n' .
                                 'مزودة بشاشة لمس قابلة للدوران وواجهة مستخدم سهلة الاستخدام، مما يجعلها مثالية للمصورين المحترفين والمبتدئين على حد سواء.',
                'quantity' => 15,
                'price' => 4999.99,
                'imagePath' => "camera-",
                'category_id' => 4,
                'published' => 1
            ],
            // Add more products with similar extended descriptions as needed
        ];
        
        
        
        
        $products2=[
            [
                'title' => 'حروف بارزة وجة أستكر',
                'headLine' => 'حروف بارزة وجة أستكر',
                'description' => "هذه الحروف البارزة منقوشة بدقة وأناقة، مثالية لإضافة لمسة جمالية لأي سطح. مصممة لتدوم طويلاً، فهي سهلة التركيب وقابلة للإزالة دون ترك أي أثر. مصنوعة من مواد عالية الجودة، مما يجعلها مقاومة للعوامل الخارجية والمتغيرة.",
                'quantity' => 15,
                'price' =>500.99,
                'imagePath' => "letter ",
                'category_id' => 6,
                'published' => 1
            ],
            [
                'title' => 'حروف بارزة  بأضائة ذكية ملونة',
                'headLine' => 'حروف بارزة  بأضائة ذكية ملونة',
                'description' => "مع مصابيح LED - تدوم طويلاً وتستهلك طاقة منخفضة مع مصابيح LED متوفرة بدرجة حرارة دافئة للغاية 2700 كلفن أو ضوء النهار الأبيض 5000 كلفن. قابلة للتكيف مع وحدة تحكم DMX لعرض جذاب للأضواء. تحكم كامل في التعتيم .",
                'quantity' => 15,
                'price' =>200.99,
                'imagePath' => "letter ",
                'category_id' => 6,
                'published' => 1
            ],
            [
                'title' => 'حروف بارزة كلادينج خشبي متوسط / أكريلك',
                'headLine' => 'حروف بارزة كلادينج خشبي متوسط / أكريلك',
                'description' => "تضفي حروف بارزة مصنوعة من الكلادينج الخشبي والأكريلك لمسة جمالية مدهشة على أي مساحة. تتميز بالصلابة والمتانة، مقاومة للعوامل الجوية، وتضفي شعورًا طبيعيًا وراقيًا. مثالية للاستخدام في الديكور الداخلي والخارجي، للافتات المحلات، المكاتب، المؤسسات والمنازل.",
                'quantity' => 15,
                'price' =>200.99,
                'imagePath' => "letter ",
                'category_id' => 6,
                'published' => 1
            ],
          
        ];
        // Loop to insert multiple products
      for ($i=0; $i <5 ; $i++) { 
        foreach ($products2 as $productData) {
            // Insert the product and get its ID
            $productId = DB::table('products')->insertGetId([
                'title' => $productData['title'],
                'quantity' => $productData['quantity'],
                'headLine' => $productData['headLine'],
                'description' => $productData['description'],
                'published' => $productData['published'],
                'price' => $productData['price'],
                'created_by' => 1, // Assuming user ID 1 for created_by
                'updated_by' => 1, // Assuming user ID 1 for updated_by
                'category_id' => $productData['category_id'],
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert associated images for the product
            // for ($j = 1; $j <= 4; $j++) { // Assuming you want to add 4 images for each product
            // $rand=$faker->randomNumber( 1, 24);
            //     $imageName = $productData['imagePath'] ."($rand)". ".jpg"; // Change this according to your image naming convention
            //    $localImagePath = "C:/Users/osama/Documents/Bluetooth/$imageName"; // Correct local path construction
            
               
            
            //     // Check if the image exists
            //     if (file_exists($localImagePath)) {
            //         // \Log::info("Reading image from: $localImagePath"); // Log the path
            //         // Read the image content from the local file
            //         $imageContent = file_get_contents($localImagePath);
            
            //         // Store the image in the public storage
            //         Storage::disk('public')->put('images/' . $imageName, $imageContent);
            
            //         // Insert image path into the product_images table
            //         DB::table('product_images')->insert([
            //             'imagePath' => 'images/' . $imageName, // Store relative path to public storage
            //             'product_id' => $productId, // Associate image with the product
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ]);
            //     } else {
            //         Log::warning("Image file does not exist: $localImagePath");
            //     }
            // }
                   

for ($j = 1; $j <= 4; $j++) { // Assuming you want to add 4 images for each product
    $rand = $faker->randomNumber(1, 24);
    $imageName = $productData['imagePath'] . "($rand)" . ".jpg"; // Create the name for the image file
    $localImagePath = "C:/Users/osama/Documents/Bluetooth/$imageName"; // Path to the local image

    $extension = pathinfo($localImagePath, PATHINFO_EXTENSION);
    $mimeType = match($extension) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'tiff', 'tif' => 'image/tiff',
        'ico' => 'image/vnd.microsoft.icon',
        
        // // Common document types
        // 'pdf' => 'application/pdf',
        // 'doc' => 'application/msword',
        // 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // 'xls' => 'application/vnd.ms-excel',
        // 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        // 'ppt' => 'application/vnd.ms-powerpoint',
        // 'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    
        // // Text and other types
        // 'txt' => 'text/plain',
        // 'csv' => 'text/csv',
        // 'json' => 'application/json',
        // 'xml' => 'application/xml',
        // 'zip' => 'application/zip',
        // 'rar' => 'application/vnd.rar',
        // '7z' => 'application/x-7z-compressed',
    
        // // Audio types
        // 'mp3' => 'audio/mpeg',
        // 'wav' => 'audio/wav',
        // 'ogg' => 'audio/ogg',
        
        // // Video types
        // 'mp4' => 'video/mp4',
        // 'mov' => 'video/quicktime',
        // 'avi' => 'video/x-msvideo',
        // 'mkv' => 'video/x-matroska',
        // 'webm' => 'video/webm',
    
        default => 'application/octet-stream', // Fallback for unknown types
    };
    
    // Check if the image file exists locally
    if (file_exists($localImagePath)) {
        // Create a temporary UploadedFile instance to use store() method
        $tempImage = new UploadedFile(
            $localImagePath,
            $imageName,
            $mimeType, // Adjust this MIME type if needed
            null,
            true // Ensure the file is marked as "test" so it’s not actually moved
        );

        // Store the image in the 'images' directory on the 'public' disk
        $path = $tempImage->store('images', 'public');

        Log::info('Uploading image with filename: ' . $path);

        // Save the path to the database
        DB::table('product_images')->insert([
            'imagePath' => $path, // Store the relative path from the 'public' disk
            'product_id' => $productId, // Link to the product
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        Log::warning("Image file does not exist: $localImagePath");
    }
}

        }
      }
    //   for ($i=0; $i <5 ; $i++) { 
    //     foreach ($products as $productData) {
    //         // Insert the product and get its ID
    //         $productId = DB::table('products')->insertGetId([
    //             'title' => $productData['title'],
    //             'quantity' => $productData['quantity'],
    //             'headLine' => $productData['headLine'],
    //             'description' => $productData['description'],
    //             'published' => $productData['published'],
    //             'price' => $productData['price'],
    //             'created_by' => 1, // Assuming user ID 1 for created_by
    //             'updated_by' => 1, // Assuming user ID 1 for updated_by
    //             'category_id' => $productData['category_id'],
    //             'deleted_by' => null,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         // Insert associated images for the product
    //         for ($j = 1; $j <= 4; $j++) { // Assuming you want to add 4 images for each product
    //             $imageName = $productData['imagePath'] . $j . ".jpeg"; // Change this according to your image naming convention
    //            $localImagePath = "C:/Users/osama/Documents/images/$imageName"; // Correct local path construction
            
               
            
    //             // Check if the image exists
    //             if (file_exists($localImagePath)) {
    //                 // \Log::info("Reading image from: $localImagePath"); // Log the path
    //                 // Read the image content from the local file
    //                 $imageContent = file_get_contents($localImagePath);
            
    //                 // Store the image in the public storage
    //                 Storage::disk('public')->put('images/' . $imageName, $imageContent);
            
    //                 // Insert image path into the product_images table
    //                 DB::table('product_images')->insert([
    //                     'imagePath' => 'images/' . $imageName, // Store relative path to public storage
    //                     'product_id' => $productId, // Associate image with the product
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             } else {
    //                 Log::warning("Image file does not exist: $localImagePath");
    //             }
    //         }
            
    //     }
    //   }
    }    
}

/**
 * 
 * <?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ar_SA');

        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 50, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

 */

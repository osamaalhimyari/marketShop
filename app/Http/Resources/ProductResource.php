<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // $id = Crypt::encrypt($this->id) ;
        return [
                'id' =>$this->id,
                'title' => $this->title,
                'headLine' => $this->headLine,
                'description' => $this->description,
                'published' => $this->published,
                'price' => $this->price,
                'views' => $this->views,
                'category_id' => $this->category_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'product_images' => ProductImagesResource::collection($this->product_images),
                'category' =>new CategoryResource($this->category),
       

        ];
    }

}

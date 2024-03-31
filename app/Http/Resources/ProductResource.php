<?php

namespace App\Http\Resources;

use App\Manager\priceManager;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'sku'=>$this->sku,
            'description'=>$this->description,
            'symbol'=>priceManager::Currency_Symbol,
            'cost'=>$this->cost. priceManager::Currency_Symbol,
            'price'=>number_format($this->price). priceManager::Currency_Symbol,
            'original_price'=>$this->price,
            'selling_price'=>priceManager::calculate_selling_price($this->price,$this->discount_fixed,$this->discount_percent,$this->discount_start,$this->discount_end),
            'stock'=>$this->stock,
            'discount_fixed'=>$this->discount_fixed .priceManager::Currency_Symbol,
            'discount_percent'=>$this->discount_percent .'%',
            'discount_start'=>$this->discount_start? $this->discount_start : null ,
            'discount_end'=>$this->discount_end? $this->discount_end : null ,

            'brand'=>$this->brand?->name,
            'category'=>$this->category?->name,
            'sub_category'=>$this->sub_category?->name,
            'country'=>$this->country?->name,
            'supplier'=>$this->supplier?->name,
            'created_by'=>$this->created_by?->name,
            'updated_by'=>$this->updated_by?->name,
            'status'=>$this->status,
            'photo'=> $this->primary_photo ? url(ProductPhoto::image_path.$this->primary_photo->photo) : null,
            'attributes'=> ProductAttributesResource::collection($this->product_attributes)
        ];
    }
}

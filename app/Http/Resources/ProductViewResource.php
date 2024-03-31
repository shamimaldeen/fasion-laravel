<?php

namespace App\Http\Resources;

use App\Manager\priceManager;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductViewResource extends JsonResource
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
            'cost'=>$this->cost. priceManager::Currency_Symbol,
            'price'=>$this->price. priceManager::Currency_Symbol,
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
            'photos'=>  ProductPhotosResource::collection($this->photos),
            'attributes'=> ProductAttributesResource::collection($this->product_attributes),
            'specifications'=>  ProductSpecificationResource::collection($this->product_specifications),
        ];
    }
}

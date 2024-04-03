<?php

namespace App\Http\Resources;

use App\Manager\priceManager;
use App\Models\ProductPhoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsListResource extends JsonResource
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
            'brand'=>$this->brand?->name,
            'photo'=> $this->photo ? url(ProductPhoto::image_path.$this->photo) : null,
            'category'=>$this->category?->name,
            'sub_category'=>$this->sub_category?->name,
            'supplier'=>$this->supplier?->name,
            'cost'=>$this->cost. priceManager::Currency_Symbol,
            'price'=>number_format($this->price). priceManager::Currency_Symbol,
            'selling_price'=>priceManager::calculate_selling_price($this->price,$this->discount_fixed,$this->discount_percent,$this->discount_start,$this->discount_end),
            'quantity'=>$this->quantity,
            'sku'=>$this->sku,
            'discount_fixed'=>$this->discount_fixed,
            'discount_percent'=>$this->discount_percent,
            'discount_start'=>$this->discount_start ? Carbon::parse($this->discount_start)->format('d-m-Y'):'',
            'discount_end'=>$this->discount_end ? Carbon::parse($this->discount_end)->format('d-m-Y'):'',
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Manager\priceManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBarcodeListResource extends JsonResource
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
                'sku'=>$this->sku,
                'price'=>number_format($this->price). priceManager::Currency_Symbol,
                'selling_price'=>priceManager::calculate_selling_price($this->price,$this->discount_fixed,$this->discount_percent,$this->discount_start,$this->discount_end),
                'discount_fixed'=>$this->discount_fixed .priceManager::Currency_Symbol,
                'discount_percent'=>$this->discount_percent .'%',
                'discount_start'=>$this->discount_start? $this->discount_start : null ,
                'discount_end'=>$this->discount_end? $this->discount_end : null ,

              ];
    }
}

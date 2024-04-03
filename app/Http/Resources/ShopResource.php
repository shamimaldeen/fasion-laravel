<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'email'=>$this->email,
            'contact'=>$this->contact,
            'logo'=> $this->logo ? url(Shop::image_path.$this->logo) : null,
            'status'=>$this->status,
            'address'=> new AddressListResource($this->addresses)
        ];
    }
}

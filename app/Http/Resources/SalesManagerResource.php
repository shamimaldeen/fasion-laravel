<?php

namespace App\Http\Resources;

use App\Models\SalesManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesManagerResource extends JsonResource
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
            'nid'=>$this->nid,
            'photo'=> $this->photo ? url(SalesManager::image_path.$this->photo) : null,
            'nid_photo'=> $this->nid_photo ? url(SalesManager::nid_image_path.$this->nid_photo) : null,
            'bio'=>$this->bio,
            'status'=>$this->status,
            'shop'=>$this->shop?->name,
            'address'=> new AddressListResource($this->addresses)
        ];
    }
}

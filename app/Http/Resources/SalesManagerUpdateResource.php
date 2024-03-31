<?php

namespace App\Http\Resources;

use App\Models\SalesManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesManagerUpdateResource extends JsonResource
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
            'bio'=>$this->bio,
            'shop_id'=>$this->shop?->id,
            'old_photo'=> $this->photo ? url(SalesManager::image_path.$this->photo) : null,
            'old_nid_photo'=> $this->nid_photo ? url(SalesManager::nid_image_path.$this->nid_photo) : null,
            'status'=>$this->status,
            'address'=>$this->addresses?->address,
            'landmark'=>$this->addresses?->landmark,
            'division_id'=>$this->addresses?->division_id,
            'district_id'=>$this->addresses?->district_id,
            'area_id'=>$this->addresses?->area_id,
        ];
    }
}

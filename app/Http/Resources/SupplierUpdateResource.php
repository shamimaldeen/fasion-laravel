<?php

namespace App\Http\Resources;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierUpdateResource extends JsonResource
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
            'old_logo'=> $this->logo ? url(Supplier::image_path.$this->logo) : null,
            'status'=>$this->status,
            'address'=>$this->addresses?->address,
            'landmark'=>$this->addresses?->landmark,
            'division_id'=>$this->addresses?->division_id,
            'district_id'=>$this->addresses?->district_id,
            'area_id'=>$this->addresses?->area_id,
        ];
    }
}

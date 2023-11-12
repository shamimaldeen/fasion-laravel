<?php

namespace App\Http\Resources;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'category_name'=>$this->category?->name,
            'slug'=>$this->slug,
            'serial'=>$this->serial,
            'description'=>$this->description,
            'photo'=> $this->photo ? url(SubCategory::image_path.$this->photo) : null,
            'status'=>$this->status,
        ];
    }
}

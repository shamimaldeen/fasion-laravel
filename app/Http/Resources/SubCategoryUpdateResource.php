<?php

namespace App\Http\Resources;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $category
 * @property mixed $slug
 * @property mixed $serial
 * @property mixed $description
 * @property mixed $photo
 * @property mixed $status
 */
class SubCategoryUpdateResource extends JsonResource
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
            'category_id'=>$this->category?->id,
            'slug'=>$this->slug,
            'serial'=>$this->serial,
            'description'=>$this->description,
            'old_photo'=> $this->photo ? url(SubCategory::image_path.$this->photo) : null,
            'status'=>$this->status,
        ];
    }
}

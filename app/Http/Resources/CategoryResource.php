<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $id
 * @property mixed $slug
 * @property mixed $serial
 * @property mixed $photo
 * @property mixed $status
 * @property mixed $description
 */
class CategoryResource extends JsonResource
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
            'serial'=>$this->serial,
            'description'=>$this->description,
            'photo'=> $this->photo ? url(Category::image_path.$this->photo) : null,
            'status'=>$this->status,
        ];
    }
}

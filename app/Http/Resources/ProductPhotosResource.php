<?php

namespace App\Http\Resources;

use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotosResource extends JsonResource
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
            'photo'=>url(ProductPhoto::image_path.$this->photo),
            'is_primary'=>$this->is_primary,
        ];
    }
}

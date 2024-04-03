<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;
    public const image_path = '/images/product/';
    protected $fillable = [
        'product_id',
        'photo',
        'is_primary',
    ];
}

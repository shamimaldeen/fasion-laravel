<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public const image_path = '/images/sub-category/';
    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'serial',
        'status',
        'description',
        'photo',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

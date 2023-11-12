<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public const image_path = '/images/brand/';
    protected $fillable = [
        'name',
        'slug',
        'serial',
        'status',
        'description',
        'logo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    use HasFactory;
    public const image_path = '/images/supplier/';
    protected $fillable = [
        'name',
        'email',
        'contact',
        'status',
        'logo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->morphOne(Address::class,'addressable');
    }
}

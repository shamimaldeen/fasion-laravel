<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    public const image_path = '/images/shop/';
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

    public function getShopDetailsById($id)
    {
        return self::query()->with('addresses',
            'addresses.division:id,name',
            'addresses.district:id,name',
            'addresses.area:id,name')->where('id',$id)->get();
    }

}

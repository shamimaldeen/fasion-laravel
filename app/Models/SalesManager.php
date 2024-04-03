<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SalesManager extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
    ];

    public const image_path = '/images/sales-manager/';
    public const nid_image_path = '/images/sales-manager/nid/';
    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'nid',
        'bio',
        'status',
        'photo',
        'nid_photo',
        'user_id',
        'shop_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->morphOne(Address::class,'addressable');
    }

    public  function  getUserByEmailOrPhone(array $input)
    {
        return self::query()->where('email',$input['email'])->orWhere('contact',$input['email'])->first();

    }

   final public function transactions(): MorphOne
    {
        return $this->morphOne(Transaction::class,'transactionable');
    }

}

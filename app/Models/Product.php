<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'category_id',
        'sub_category_id',
        'supplier_id',
        'country_id',
        'cost',
        'price',
        'discount_percent',
        'discount_fixed',
        'discount_start',
        'discount_end',
        'stock',
        'sku',
        'description',
        'created_by_id',
        'updated_by_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by_id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class,'updated_by_id');
    }

    public function primary_photo()
    {
        return $this->hasOne(ProductPhoto::class)->where('is_primary',1);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function product_specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function getProductById(int $id)
    {
          return self::query()->with('primary_photo')->findOrFail($id);
    }

}

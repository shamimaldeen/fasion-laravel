<?php

namespace App\Models;

use App\Manager\priceManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function storeOrderDetails(array $products,$order):void
    {
        foreach ($products as $key=> $product){
            $order_details_data = $this->prepareOrderDetailsData($product,$order);
            self::query()->create($order_details_data);
        }
    }

    public function prepareOrderDetailsData($product,$order)
    {
       return [
               'order_id'=>$order->id,
               'product_id'=>$product->id,
               'name'=>$product->name,
               'brand_id'=>$product->brand_id,
               'category_id'=>$product->category_id,
               'sub_category_id'=>$product->sub_category_id,
               'supplier_id'=>$product->supplier_id,
               'cost'=>$product->cost,
               'discount_start'=>$product->discount_start,
               'discount_end'=>$product->discount_end,
               'discount_fixed'=>$product->discount_fixed,
               'discount_percent'=>$product->discount_percent,
               'price'=>$product->price,
               'selling_price'=>priceManager::calculate_selling_price($product->price,$product->discount_fixed,$product->discount_percent,$product->discount_start,$product->discount_end)['price'],
               'sku'=>$product->sku,
               'quantity'=>$product->quantity,
               'photo'=>$product->primary_photo?->photo,
              ];
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }



    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }


}

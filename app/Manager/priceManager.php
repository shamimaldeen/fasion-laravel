<?php
namespace App\Manager;

use Carbon\Carbon;

class priceManager{
  public const Currency_Symbol = '৳';
  public const Currency_Name = 'BDT';

  public  static  function  calculate_selling_price(int $price,int $discount_fixed,int $discount_percent, string|null $discount_start = '',string|null $discount_end='')
  {
      $discount = 0;
      if (!empty($discount_start) && !empty($discount_end)){
          if (Carbon::now()->isBetween(Carbon::create($discount_start),Carbon::create($discount_end))){
              return self::calculate_price($price,$discount_fixed,$discount_percent);
          }
      }
      return ['price'=>$price,'discount'=>$discount,'symbol'=>self::Currency_Symbol];
  }

  private static function calculate_price(int $price,int $discount_fixed,int $discount_percent)
  {
       $discount = 0;
       if (!empty($discount_percent)){
           $discount = ($price * $discount_percent)/100;
       }
      if (!empty($discount_fixed)){
          $discount += $discount_fixed;
      }
      return ['price'=>$price-$discount,'discount'=>$discount,'symbol'=>self::Currency_Symbol];
  }


}

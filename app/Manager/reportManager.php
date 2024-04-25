<?php

namespace App\Manager;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class reportManager{

    //Stock Data
    public const low_stock_alert = 25;
    public  int $total_product = 0 ;
    public  int $total_stock = 0 ;
    public  int $low_stock = 0 ;
    public  int $total_buying_price = 0 ;
    public  int $total_selling_price = 0 ;
    public  int $total_possible_profit = 0 ;
    private Collection $products;


    // Sales Report data

    public int $total_sale = 0;
    public  int $total_sale_today = 0 ;
    public  int $total_purchase = 0 ;
    public  int $total_purchase_today = 0 ;

    private bool $is_admin = false;
    private int $is_admin_id;
    private Collection $orders;

    function __construct($auth)
    {
        if ($auth->guard('admin')->check()){
            $this->is_admin = true;
        }
        $this->is_admin_id = $auth->user()->id;
       $this->getProducts();
       $this->setTotalProduct();
       $this->countTotalStock();
       $this->countlowStockAlert();
       $this->calculateBuyingPrice();
       $this->calculateSellingPrice();
       $this->calculatePossibleProfit();

        $this->getOrderData();
        $this->totalSale();
        $this->totalSaleToday();
        $this->calculateTotalPurchase();
        $this->calculatePurchaseToday();


    }

    private  function getProducts()
    {
       $this->products = (new Product)->getAllProduct();
    }
     private function setTotalProduct()
     {
         $this->total_product = count($this->products);
     }
    private function countTotalStock()
    {
        $this->total_stock = $this->products->sum('stock');
    }
    private function countlowStockAlert()
    {
        $this->low_stock = $this->products->where('stock' ,'<=',self::low_stock_alert)->count();
    }

    private function calculateBuyingPrice()
    {
         foreach ($this->products as $product){
             $this->total_buying_price += ($product->cost * $product->stock);
         }
    }
    private function calculateSellingPrice()
    {
         foreach ($this->products as $product){
             $this->total_selling_price += ($product->price * $product->stock);
         }
    }
    private function calculatePossibleProfit()
    {
        $this->total_possible_profit = $this->total_selling_price - $this->total_buying_price;
    }

    private  function getOrderData()
    {
        $this->orders = (new Order())->getAllOrderReportData($this->is_admin, $this->is_admin_id);
    }
    private function totalSale()
    {
        $this->total_sale = $this->orders->sum('total');
    }
    private function totalSaleToday()
    {
        $this->total_sale_today = $this->orders->whereBetween('created_at',[Carbon::today()->startOfDay()->format('Y-m-d H:i:s') ,Carbon::today()->endOfDay()->format('Y-m-d H:i:s') ])->sum('total');
    }


    private function calculateTotalPurchase()
    {
       $this->total_purchase = $this->total_buying_price;
    }

    private function calculatePurchaseToday()
    {
        $products_purchase = $this->products->whereBetween('created_at',[Carbon::today()->startOfDay()->format('Y-m-d H:i:s') ,Carbon::today()->endOfDay()->format('Y-m-d H:i:s') ]);
        foreach ($products_purchase as $product){
            $this->total_purchase_today += ($product->cost * $product->stock);
        }
    }


}


































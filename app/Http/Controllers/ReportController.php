<?php

namespace App\Http\Controllers;

use App\Manager\priceManager;
use App\Manager\reportManager;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
       $reportManagers = new reportManager(auth());
       //dd($reportManagers->total_purchase_today);
      $reports = [
           'total_product' => $reportManagers->total_product,
           'total_stock' => $reportManagers->total_stock,
           'low_stock' => $reportManagers->low_stock,
           'total_buying_price' => priceManager::priceFormat($reportManagers->total_buying_price),
           'total_selling_price' => priceManager::priceFormat($reportManagers->total_selling_price),
           'total_possible_profit' =>priceManager::priceFormat($reportManagers->total_possible_profit),
           'total_sale' =>priceManager::priceFormat($reportManagers->total_sale),
           'total_sale_today' =>priceManager::priceFormat($reportManagers->total_sale_today),
           'total_purchase' =>priceManager::priceFormat($reportManagers->total_purchase),
           'total_purchase_today' =>priceManager::priceFormat($reportManagers->total_purchase_today),
      ];
      return response()->json($reports);

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;
        $is_admin = auth()->guard('admin')->check();
        $query = Order::query()->with([
            'customer:id,name,phone',
            'sales_manager:id,name',
            'shop:id,name',
            'payment_method:id,name',
        ]);
        if (!$is_admin){
            $query->where('shop_id',auth()->user()->shop_id);
        }
//        if ($search){
//            $query->where('name','like','%'.$request->search.'%')
//                ->orWhere('sku','like','%'.$request->search.'%');
//        }
         $orders = $query->paginate($per_page);
        return OrderResource::collection($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();
          $order = (new Order)->placeOrder($request->all(),auth()->user());
            DB::commit();
            return response()->json([
                'msg' => "Order Placed successfully.",
                'cls' => "success",
                'flag'=>1
            ],200);

        } catch (\Exception $e) {
            info('ORDER_PLACE_FAILED',['meassage'=>$e->getMessage(),$e]);
            DB::rollBack();
            return response()->json([
                'msg' => "Oops ! Something went really wrong!",
                'cls' => "error"
            ],500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
         $order->load('customer','sales_manager','shop','payment_method','order_details');
         return new OrderDetailsResource($order);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order_status = "Completed";
        if ( $this->order_status == Order::STATUS_PENDING){
            $order_status = "Pending";
        }elseif ($this->order_status == Order::STATUS_PROCESSED){
            $order_status = "Processed";
        }

        $payment_status = "Unpaid";
        if ( $this->payment_status == Order::PAYMENT_STATUS_PAID){
            $payment_status = "Paid";
        }elseif ($this->payment_status == Order::PAYMENT_STATUS_PARTIALLY_PAID){
            $payment_status = "Partially Paid";
        }

        return [
            'id'=>$this->id,
            'customer'=>new CustomerResource($this->customer),
            'order_number'=>$this->order_number,
            'order_status'=>$this->order_status,
            'order_status_show'=>$order_status,
            'payment_method'=>new  PaymentDetailsResource($this->payment_method),
            'payment_status'=>$this->payment_status,
            'payment_status_show'=>$payment_status,
            'sales_manager'=>new SalesManagerResource($this->sales_manager),
            'shop'=>new ShopResource($this->shop),
            'paid_amount'=>$this->paid_amount,
            'due_amount'=>$this->due_amount,
            'sub_total'=>$this->sub_total,
            'discount'=>$this->discount,
            'quantity'=>$this->quantity,
            'total'=>$this->total,
            'created_at'=> Carbon::parse($this->created_at)->format("d-m-Y"),
            'updated_at'=>$this->created_at != $this->updated_at? Carbon::parse($this->updated_at)->format("d-m-Y") : 'Not Updated' ,
            'order_details'=> OrderDetailsListResource::collection($this->order_details),
            'transactions'=> TransactionDetailsListResource::collection($this->transactions)
        ];
    }
}

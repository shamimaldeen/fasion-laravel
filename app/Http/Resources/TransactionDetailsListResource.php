<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
                    'id'=>$this->id,
                    'trans_id'=>$this->trans_id,
                    'amount'=>$this->amount,
                    'customer_name'=>$this->customer?->name,
                    'customer_phone'=>$this->customer?->phone,
                    'payment_method'=>$this->payment_method?->name,
                    'account_number'=>$this->payment_method?->account_number,
                    'status'=>$this->status == Transaction::STATUS_SUCCESS ? 'Success':'Failed',
                    'transaction_type'=>$this->transaction_type == Transaction::CREDIT ? 'Credit':'Debit',
                     'created_at'=> Carbon::parse($this->created_at)->format("d-m-Y"),
                    'transaction_by'=>$this->transactionable?->name,
              ];
     }
}

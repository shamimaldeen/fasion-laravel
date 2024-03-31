<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_methods = [
            [
              'name'=>'Cash',
              'account_number'=>'',
              'status'=>1,
            ],
            [
                'name'=>'bKash',
                'account_number'=>'01738298777',
                'status'=>1,
            ],
            [
                'name'=>'Nagad',
                'account_number'=>'01738298777',
                'status'=>1,
            ],
            [
                'name'=>'Roket',
                'account_number'=>'01738298777',
                'status'=>1,
            ],
        ];

         PaymentMethod::insert($payment_methods);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('user')->orderBy('id','DESC')->paginate(10);
        return CustomerResource::collection($customers);
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
    public function store(StoreCustomerRequest $request)
    {
        try {

            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Customer Created successfully.",
                'cls' => "success"
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => "Oops ! Something went really wrong!",
                'cls' => "error"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $customer = Customer::find($id);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'msg' => "Customer Updated Successfully.",
                'cls' => "success"
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => "Oops ! Something went really wrong!",
                'cls' => "error"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return response()->json([
            'msg' => "Customer Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }

    public function getAllCustomer(Request $request)
    {

        $search = $request->search;
        $query = Customer::query();
        if ($search){
            $query->where('name','like','%'.$request->search.'%')
                ->orWhere('phone','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%');
        }
        $customers = $query->take(15)->get();
        return $customers;
    }



}

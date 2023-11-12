<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupplierResource;
use App\Models\Address;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;
        $query = Supplier::query()->with(
            'addresses',
            'addresses.division:id,name',
            'addresses.district:id,name',
            'addresses.area:id,name',
        );
        if ($search){
            $query->where('name','like','%'.$request->search.'%')
                  ->orWhere('phone','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
        }

        if ($request->direction){
            $query->orderBy('id',$request->direction ?? 'asc');
        }
        $suppliers = $query->where('status',$request->status)->paginate($per_page);
        return SupplierResource::collection($suppliers);
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
    public function store(StoreSupplierRequest $request)
    {
        try {
            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(Supplier::image_path),$imageName);
            }else{
                $imageName = null;
            }
           $supplier =  Supplier::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'status' => $request->status,
                'logo' => $imageName,
                'user_id' => auth()->id(),
            ]);
          $addressdata = (new Address())->prepareData($request->all());
          $supplier->addresses()->create($addressdata);
            return response()->json([
                'msg' => "Supplier successfully created.",
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
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}

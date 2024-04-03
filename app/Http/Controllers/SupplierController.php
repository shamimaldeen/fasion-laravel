<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierUpdateResource;
use App\Models\Address;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                  ->orWhere('contact','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
        }


        $suppliers = $query->paginate($per_page);

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
            DB::beginTransaction();
            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $imageName =$request->name.'-'.Str::random(15).".".$image->getClientOriginalExtension();
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
          DB::commit();
            return response()->json([
                'msg' => "Supplier successfully created.",
                'cls' => "success"
            ],200);


        } catch (\Exception $e) {
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
    public function show(Supplier $supplier)
    {
        $supplier->load('addresses');
        return   new SupplierUpdateResource($supplier);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            $supplierData = Supplier::find($id);

            if($request->hasFile('logo')){
                if (!empty($supplierData->logo)){
                    $path = public_path(Supplier::image_path).$supplierData->logo;
                    if ($supplierData->logo != '' && file_exists($path)){
                        unlink($path);
                    }
                }
                $logo = $request->file('logo');
                $imageName =$request->name.'-'.Str::random(15).".".$logo->getClientOriginalExtension();
                $logo->move(public_path(Supplier::image_path),$imageName);
            }else{
                $imageName = $supplierData->logo;
            }
            $supplierData->update([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'status' => $request->status,
                'logo' => $imageName,
                'user_id' => auth()->id(),
            ]);

            $addressdata = (new Address())->prepareData($request->all());
            $supplierData->addresses()->update($addressdata);
            DB::commit();
            return response()->json([
                'msg' => "Supplier Updated Successfully.",
                'cls' => "success"
            ],200);


        } catch (\Exception $e) {
            DB::rollBack();
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
        $supplier = Supplier::find($id);
        if (!empty($supplier->logo)){
            $path = public_path(Supplier::image_path).$supplier->logo;
            if ($supplier->logo != '' && file_exists($path)){
                unlink($path);
            }
        }
        Address::where('addressable_id',$id)->delete();
        $supplier->delete();

        return response()->json([
            'msg' => "Supplier Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }


    public function getAllSuppliers()
    {
        $suppliers =  Supplier::where('status',1)->select('id','name','contact')->orderBy('name','ASC')->get();
        return $suppliers;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopUpdateResource;
use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $query = Shop::query()->with(
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
        $shops = $query->paginate($per_page);
        return ShopResource::collection($shops);
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
    public function store(StoreShopRequest $request)
    {
        try {
            DB::beginTransaction();
            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(Shop::image_path),$imageName);
            }else{
                $imageName = null;
            }
            $shop =  Shop::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'status' => $request->status,
                'logo' => $imageName,
                'user_id' => auth()->id(),
            ]);
            $addressdata = (new Address())->shopPrepareData($request->all());
            $shop->addresses()->create($addressdata);
            DB::commit();
            return response()->json([
                'msg' => "Shop successfully created.",
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
    public function show(Shop $shop)
    {
        $shop->load('addresses');
        return   new ShopUpdateResource($shop);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $shopData = Shop::find($id);

            if($request->hasFile('logo')){
                if (!empty($shopData->logo)){
                    $path = public_path(Shop::image_path).$shopData->logo;
                    if ($shopData->logo != '' && file_exists($path)){
                        unlink($path);
                    }
                }
                $logo = $request->file('logo');
                $imageName =$request->slug.'-'.Str::random(15).".".$logo->getClientOriginalExtension();
                $logo->move(public_path(Shop::image_path),$imageName);
            }else{
                $imageName = $shopData->logo;
            }
            $shopData->update([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'status' => $request->status,
                'logo' => $imageName,
                'user_id' => auth()->id(),
            ]);

            $addressdata = (new Address())->prepareData($request->all());
            $shopData->addresses()->update($addressdata);
            DB::commit();
            return response()->json([
                'msg' => "Shop Updated Successfully.",
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
        $shop = Shop::find($id);
        if (!empty($shop->logo)){
            $path = public_path(Shop::image_path).$shop->logo;
            if ($shop->logo != '' && file_exists($path)){
                unlink($path);
            }
        }
        Address::where('addressable_id',$id)->delete();
        $shop->delete();

        return response()->json([
            'msg' => "Shop Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }

    public function getAllShops()
    {
        $shops =  Shop::where('status',1)->select('id','name')->orderBy('name','ASC')->get();
        return $shops;
    }
}

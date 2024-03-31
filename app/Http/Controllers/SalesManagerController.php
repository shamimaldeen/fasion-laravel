<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesManagerResource;
use App\Http\Resources\SalesManagerUpdateResource;
use App\Models\Address;
use App\Models\SalesManager;
use App\Http\Requests\StoreSalesManagerRequest;
use App\Http\Requests\UpdateSalesManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class SalesManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $query = SalesManager::query()->with(
            'addresses',
            'addresses.division:id,name',
            'addresses.district:id,name',
            'addresses.area:id,name',
            'shop:id,name',
        );
        if ($search){
            $query->where('name','like','%'.$request->search.'%')
                ->orWhere('contact','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%');
        }


        $salesManagers = $query->paginate($per_page);

        return SalesManagerResource::collection($salesManagers);
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
    public function store(StoreSalesManagerRequest $request)
    {
        try {
            DB::beginTransaction();
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $imageName =$request->nid.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(SalesManager::image_path),$imageName);
            }else{
                $imageName = null;
            }

            if($request->hasFile('nid_photo')){
                $image = $request->file('nid_photo');
                $nidImageName =$request->nid.'-'.Str::random(10).".".$image->getClientOriginalExtension();
                $image->move(public_path(SalesManager::nid_image_path),$imageName);
            }else{
                $nidImageName = null;
            }
            $salesManager =  SalesManager::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nid' => $request->nid,
                'bio' => $request->bio,
                'status' => $request->status,
                'photo' => $imageName,
                'nid_photo' => $nidImageName,
                'shop_id' => $request->shop_id,
                'user_id' => auth()->id(),
            ]);
            $addressdata = (new Address())->salesPrepareData($request->all());
            $salesManager->addresses()->create($addressdata);
            DB::commit();
            return response()->json([
                'msg' => "Sales Manager successfully created.",
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
    public function show(SalesManager $salesManager)
    {
        $salesManager->load('addresses','shop');
        return   new SalesManagerUpdateResource($salesManager);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesManager $salesManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesManagerRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $salesManagerData = SalesManager::find($id);

            if($request->hasFile('photo')){
                if (!empty($salesManagerData->photo)){
                    $path = public_path(SalesManager::image_path).$salesManagerData->photo;
                    if ($salesManagerData->photo != '' && file_exists($path)){
                        unlink($path);
                    }
                }
                $photo = $request->file('photo');
                $imageName =$request->nid.'-'.Str::random(10).".".$photo->getClientOriginalExtension();
                $photo->move(public_path(SalesManager::image_path),$imageName);
            }else{
                $imageName = $salesManagerData->photo;
            }

            if($request->hasFile('nid_photo')){
                if (!empty($salesManagerData->nid_photo)){
                    $path = public_path(SalesManager::nid_image_path).$salesManagerData->nid_photo;
                    if ($salesManagerData->nid_photo != '' && file_exists($path)){
                        unlink($path);
                    }
                }
                $nid_photo = $request->file('nid_photo');
                $nidimageName =$request->nid.'-'.Str::random(10).".".$nid_photo->getClientOriginalExtension();
                $nid_photo->move(public_path(SalesManager::nid_image_path),$nidimageName);
            }else{
                $nidimageName = $salesManagerData->nid_photo;
            }

            $salesManagerData->update([
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'nid' => $request->nid,
                'bio' => $request->bio,
                'status' => $request->status,
                'photo' => $imageName,
                'nid_photo' => $nidimageName,
                'shop_id' => $request->shop_id,
                'user_id' => auth()->id(),
            ]);

            $addressdata = (new Address())->prepareData($request->all());
            $salesManagerData->addresses()->update($addressdata);
            DB::commit();
            return response()->json([
                'msg' => "Sales Manager Updated Successfully.",
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
        $salesManager = SalesManager::find($id);
        if (!empty($salesManager->photo)){
            $path = public_path(SalesManager::image_path).$salesManager->photo;
            if ($salesManager->photo != '' && file_exists($path)){
                unlink($path);
            }
        }

        if (!empty($salesManager->nid_photo)){
            $path = public_path(SalesManager::nid_image_path).$salesManager->nid_photo;
            if ($salesManager->nid_photo != '' && file_exists($path)){
                unlink($path);
            }
        }
        Address::where('addressable_id',$id)->delete();
        $salesManager->delete();

        return response()->json([
            'msg' => "Sales Manager Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandUpdateResource;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $query = Brand::query();

        if ($search){
            $query->where('name','like','%'.$request->search.'%');
        }

        if ($request->direction){
            $query->orderBy('id',$request->direction ?? 'asc');
        }
        $brands = $query->where('status',$request->status)->paginate($per_page);
        return BrandResource::collection($brands);
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
    public function store(StoreBrandRequest $request)
    {
        try {
            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(Brand::image_path),$imageName);
            }else{
                $imageName = null;
            }
            Brand::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'serial' => $request->serial,
                'status' => $request->status,
                'logo' => $imageName,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Brand successfully created.",
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
    public function show(Brand $brand)
    {
        return  new BrandUpdateResource($brand);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request,$id)
    {
        try {
            $brand = Brand::find($id);
            if($request->hasFile('logo')){
                if (!empty($brand->logo)){
                    $path = public_path(Brand::image_path).$brand->logo;
                    if ($brand->logo != '' && file_exists($path)){
                        unlink($path);
                    }
                }
                $logo = $request->file('logo');
                $imageName =$request->slug.'-'.Str::random(15).".".$logo->getClientOriginalExtension();
                $logo->move(public_path(Brand::image_path),$imageName);
            }else{
                $imageName = $brand->logo;
            }

            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'serial' => $request->serial,
                'status' => $request->status,
                'logo' => $imageName,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Brand successfully Updated.",
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
        $brand = Brand::find($id);
        if (!empty($brand->logo)){
            $path = public_path(Brand::image_path).$brand->logo;
            if ($brand->logo != '' && file_exists($path)){
                unlink($path);
            }
        }
        $brand->delete();

        return response()->json([
            'msg' => "Brand Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

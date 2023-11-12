<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubCategoryUpdateResource;
use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // return $request->all();
        $per_page = $request->per_page ?? 10;
        $search = $request->search;
        $category_id = $request->category_id;

        $query = SubCategory::query();

        if ($search){
            $query->where('name','like','%'.$request->search.'%');
        }
        if ($category_id){
            $query->where('category_id',$request->category_id);
        }

        if ($request->direction){
            $query->orderBy('id',$request->direction ?? 'asc');
        }
        $subCategories = $query->with('category:id,name')->paginate($per_page);

        return SubCategoryResource::collection($subCategories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        try {
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(SubCategory::image_path),$imageName);
            }else{
                $imageName = null;
            }
            SubCategory::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'slug' => $request->slug,
                'serial' => $request->serial,
                'status' => $request->status,
                'photo' => $imageName,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Sub Category successfully created.",
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
    public function show($id)
    {
         $subCategory = SubCategory::find($id);

        return  new SubCategoryUpdateResource($subCategory);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, $id)
    {
        try {
            $subCategory = SubCategory::find($id);

            if($request->hasFile('photo')){

                if (!empty($subCategory->photo)){
                    $path = public_path(SubCategory::image_path).$subCategory->photo;
                    if ($subCategory->photo != '' && file_exists($path)){
                        unlink($path);
                    }
                }

                $image = $request->file('photo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path(SubCategory::image_path),$imageName);
            }else{
                $imageName = $subCategory->photo;
            }

            $subCategory->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'slug' => $request->slug,
                'serial' => $request->serial,
                'status' => $request->status,
                'photo' => $imageName,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Sub Category successfully Updated.",
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
        $subCategory = SubCategory::find($id);
        if (!empty($subCategory->photo)){
            $path = public_path(SubCategory::image_path).$subCategory->photo;
            if ($subCategory->photo != '' && file_exists($path)){
                unlink($path);
            }
        }
        $subCategory->delete();

        return response()->json([
            'msg' => "Sub Category Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

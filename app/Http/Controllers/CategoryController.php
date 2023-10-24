<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $imageName =$request->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                $image->move(public_path('/images/category/'),$imageName);
            }else{
                $imageName = null;
            }
            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'serial' => $request->serial,
                'status' => $request->status,
                'photo' => $imageName,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Category successfully created.",
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
    public function show(Category $category)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryUdateResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $per_page = $request->per_page ?? 10;
         $search = $request->search;

         $query = Category::query();

         if ($search){
             $query->where('name','like','%'.$request->search.'%');
         }

        if ($request->direction){
            $query->orderBy('id',$request->direction ?? 'asc');
        }
        $categories = $query->where('status',$request->status)->paginate($per_page);
         return CategoryResource::collection($categories);

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
                $image->move(public_path(Category::image_path),$imageName);
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
        return  new CategoryUdateResource($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
           $data =  $request->all();
            $catego  =   Category::find($request->id);
            $catego->update($data);

        return response()->json([
            'msg' => "Category successfully Updated.",
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
    public function destroy(Category $category)
    {
       if (!empty($category->photo)){
           $path = public_path(Category::image_path).$category->photo;
           if ($category->photo != '' && file_exists($path)){
               unlink($path);
           }
       }
       $category->delete();

        return response()->json([
            'msg' => "Category Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

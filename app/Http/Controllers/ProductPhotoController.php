<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Http\Requests\StoreProductPhotoRequest;
use App\Http\Requests\UpdateProductPhotoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request,$id)
    {

        try {
            if($request->hasFile('photo')){
                 $product = Product::find($id);
                 if ($product){
                     $image = $request->file('photo');
                     $imageName =$product->slug.'-'.Str::random(15).".".$image->getClientOriginalExtension();
                     $image->move(public_path(ProductPhoto::image_path),$imageName);

                     ProductPhoto::create([
                         'product_id' => $id,
                         'photo' => $imageName,
                         'is_primary' => $request->is_primary,
                     ]);
                     return response()->json([
                         'msg' => "Product Photo successfully Uploaded.",
                         'cls' => "success"
                     ],200);
                 }
            }
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
    public function show(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductPhotoRequest $request, ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPhoto $productPhoto)
    {
        //
    }
}

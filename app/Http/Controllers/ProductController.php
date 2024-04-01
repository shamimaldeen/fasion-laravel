<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductViewResource;
use App\Models\Address;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductAttribute;
use App\Models\ProductPhoto;
use App\Models\ProductSpecification;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $query = Product::query()->with([
            'category:id,name',
            'sub_category:id,name',
            'brand:id,name',
            'country:id,name',
            'supplier:id,name,contact',
            'created_by:id,name',
            'updated_by:id,name',
            'primary_photo',
            'product_attributes',
            'product_attributes.attributes',
            'product_attributes.attribute_value',

            ]);
        if ($search){
            $query->where('name','like','%'.$request->search.'%')
                   ->orWhere('sku','like','%'.$request->search.'%');
        }
        $products = $query->paginate($per_page);

        return ProductResource::collection($products);
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
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
              $attributes = $request->input('attributes');
              $specifications = $request->input('specifications');

              $data = $request->all();
              $data['slug'] = Str::slug($request->slug);
              $data['created_by_id'] = auth()->id();

              $product =  Product::create($data);

            if ($request->has('attributes')){
                if (count($attributes) > 0){
                    foreach ($attributes as $attribute){
                        $product_attribute = new ProductAttribute();
                        $product_attribute->product_id = $product->id;
                        $product_attribute->attribute_id = $attribute['attribute_id'];
                        $product_attribute->attribute_value_id = $attribute['value_id'];
                        $product_attribute->save();

                    }
                }
            }

            if ($request->has('specifications')){
                if (count($specifications) > 0){
                    foreach ($specifications as $specification){
                        $product_specification = new ProductSpecification();
                        $product_specification->product_id = $product->id;
                        $product_specification->name = $specification['name'];
                        $product_specification->value = $specification['value'];
                        $product_specification->save();
                    }
                }
            }

            DB::commit();
            return response()->json([
                'msg' => "Product successfully created.",
                'cls' => "success",
                'product_id' => $product->id,
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
    public function show($id)
    {
        $product = Product::with([
            'category:id,name',
            'sub_category:id,name',
            'brand:id,name',
            'country:id,name',
            'supplier:id,name,contact',
            'created_by:id,name',
            'updated_by:id,name',
            'photos',
            'product_attributes',
            'product_attributes.attributes',
            'product_attributes.attribute_value',
            'product_specifications',
            ])->where('id',$id)->first();
        return  new ProductViewResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

       $product_photos =  ProductPhoto::where('product_id',$id)->get();

       foreach ($product_photos as $val){
           if (!empty($val->photo)){
               $path = public_path(ProductPhoto::image_path).$val->logo;
               if ($val->logo != '' && file_exists($path)){
                   unlink($path);
               }
           }
       }
        $product_attributes=  ProductAttribute::where('product_id',$id)->get();
       foreach ($product_attributes as $attribute){
               $attribute->delete();
           }


        $product_specifications=  ProductSpecification::where('product_id',$id)->get();
        foreach ($product_specifications as $specification){
            $specification->delete();
         }
        $product->delete();

        return response()->json([
            'msg' => "Product Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

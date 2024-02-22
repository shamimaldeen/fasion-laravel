<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeValueResource;
use App\Models\AttributeValue;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributevalues = AttributeValue::with('attribute')->orderBy('id','DESC')->paginate(10);
        return AttributeValueResource::collection($attributevalues);
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
    public function store(StoreAttributeValueRequest $request)
    {

        try {

            AttributeValue::create([
                'name' => $request->name,
                'attribute_id' => $request->attribute_id,
            ]);

            return response()->json([
                'msg' => "Attribute Value Successfully Added.",
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
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeValueRequest $request,$id)
    {
        try {
            $attributeValue = AttributeValue::find($id);
            $attributeValue->update([
                'name' => $request->name,
                'attribute_id' => $request->attribute_id
            ]);
            return response()->json([
                'msg' => "Attribute Value Successfully Updated.",
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
        $attributeValue = AttributeValue::find($id);
        $attributeValue->delete();

        return response()->json([
            'msg' => "Attribute Value Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

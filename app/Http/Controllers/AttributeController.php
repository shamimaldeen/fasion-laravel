<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeResource;
use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::with('user')->orderBy('id','DESC')->paginate(10);
        return AttributeResource::collection($attributes);
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
    public function store(StoreAttributeRequest $request)
    {
        try {

            Attribute::create([
                'name' => $request->name,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Attribute Created successfully.",
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
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request,$id)
    {
        try {
            $attribute = Attribute::find($id);

            $attribute->update([
                'name' => $request->name,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'msg' => "Attribute Updated Successfully.",
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
        $attribute = Attribute::find($id);
        $attribute->delete();

        return response()->json([
            'msg' => "Attribute Deleted Successfully.",
            'cls' => "warning"
        ],200);
    }
}

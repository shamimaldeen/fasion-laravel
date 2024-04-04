<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\ShopResource;
use App\Models\SalesManager;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public  function  login(AuthRequest $request)
    {
        if ($request->user_type == 1){
            $user = (new User())->getUserByEmailOrPhone($request->all());
            $contact = $user->phone;
        }else{
            $user = (new SalesManager())->getUserByEmailOrPhone($request->all());
            $contact = $user->contact;
        }
        if ($user && Hash::check($request->input('password'),$user->password))
        {
            $user_data['token'] = $user->createToken($user->email)->plainTextToken;
            $user_data['name'] = $user->name;
            $user_data['email'] = $user->email;
            $user_data['phone'] = $contact;
            $user_data['role_id'] = $request->user_type;
            $user_data['photo'] = $user->photo;
            $user_data['user_type'] = $request->user_type;

            if ($request->user_type == 1){
                $branch = null;
                $user_data['branch'] = $branch;
            }else{
                $branch = (new Shop())->getShopDetailsById($user->shop_id);
                $user_data['branch'] =  ShopResource::collection($branch);
            }
            return response()->json($user_data);
        }
        throw ValidationException::withMessages([
            'email' => ['The Provided credentials are incorrect']
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

   final public  function logout(Request $request):JsonResponse
    {

         auth()->user()->tokens()->delete();
         return response()->json(['msg'=>'You are Successfully Logged Out !']);
    }
}

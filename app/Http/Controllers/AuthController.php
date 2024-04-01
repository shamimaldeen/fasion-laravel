<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
  final  public  function  login(AuthRequest $request): JsonResponse
    {
        $user = (new User())->getUserByEmailOrPhone($request->all());
        if ($user && Hash::check($request->input('password'),$user->password))
        {
            $user_data['token'] = $user->createToken($user->email)->plainTextToken;
            $user_data['name'] = $user->name;
            $user_data['email'] = $user->email;
            $user_data['phone'] = $user->phone;
            $user_data['role_id'] = $user->role_id;
            $user_data['photo'] = $user->photo;
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

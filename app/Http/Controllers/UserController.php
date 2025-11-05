<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
           
        ]);
        if ($validatedData->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error', 'errors' => $validatedData->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            
            'email' => $request->email,
            'address' => $request->address,
            
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => True,
            'message' => 'success',
            'token'=>$user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
}

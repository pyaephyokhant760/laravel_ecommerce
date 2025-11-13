<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        logger()->info('Admin logged in successfully');
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string|min:6',    
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ],422);
        }
        $user = Auth::user();
        log::info($user);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            logger()->info('Admin logged in successfully');
            $user = Auth::user();
            if($user->role == 'admin'){
                
                $token = $user->createToken('admin_token')->plainTextToken;
                

                return response()->json([
                    'status'=>true,
                    'message'=>'Admin logged in successfully',
                    'access_token'=>$token,
                    'token_type'=>'Bearer',
                    'user'=>$user
                ],200);
            }
            
           
        }
        
    }
}

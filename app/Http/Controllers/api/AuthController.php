<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $santri = Santri::where('username', $request->username)->first();
        if ( $santri && Hash::check($request->password, $santri->password)) {
            return response()->json([
                'status'      => 'succes',
                'message'     => 'Login success',
                'access_token'=> $santri->createToken('auth_token')->plainTextToken,
                'token_type'  => 'Bearer'
            ],200);
        }
        return response()->json([
            'status'      => 'error',
            'message'     => 'Unauthorized'
        ],401);
    }

}

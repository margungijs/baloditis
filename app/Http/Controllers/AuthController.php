<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Input missing', 'details' => $validator->errors()], 422);
        }

        $credentials = $request->only('name', 'password');

        $user = User::where('name', $credentials['name'] ?? '')->first();

        if (!$user) {
            return response()->json(['name' => 'Username not found'], 401);
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            $expirationTimeInMinutes = 60;
            $token = $user->createToken('authToken', ['*'], null, 3600)->accessToken;
            $token->expires_at = now()->addMinutes($expirationTimeInMinutes);
            $token->save();

            return response()->json(['token' => $token->token, 'expire' => $token->expires_at, 'role' => $user->role], 200);
        }

        return response()->json(['password' => 'Password incorrect'], 401);
    }
}

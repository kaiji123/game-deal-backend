<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $user = User::where('username', $request->username)->first();
    
        if ($user) {
            return response()->json(['error' => 'Username already exists'], 422);
        }
    
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    try {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'error' => ['Invalid username or password'],
            ]);
        }

        $user = $request->user();
        // info($user);
        $token = $user->createToken(time())->plainTextToken;
        $userId = Auth::id();
        
        info($userId);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    } catch (ValidationException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    }
}

}



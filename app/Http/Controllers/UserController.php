<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:project_users,email',
            'password'=>'required|string|min:8|confirmed',
            'college_id'=>'required|exists:colleges,id',
            'student_number'=>'required|string|unique:project_users,student_number'
        ]);

        $email = strtolower(trim($request->email));
        $hash = md5($email);
        $profile_image = "https://www.gravatar.com/avatar/{$hash}?s=200&d=identicon";

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'college_id' => $request->college_id,
            'student_number' => $request->student_number,
            'role' => 'student',
            'is_active' => true,
            'profile_image' => $profile_image,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Registered Successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
        'email'=>'required|email',
        'password'=>'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}

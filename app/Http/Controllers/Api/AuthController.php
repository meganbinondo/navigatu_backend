<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    /**
     * Login the specified resource.
     */
    public function login(UserRequest $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $user->load('role');

    $response = [
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'organization' => $user->organization,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'role' => $user->role,
        ],
        'token' => $user->createToken($request->email)->plainTextToken,
        'success' => 'Login successfully',
    ];

    return response()->json($response);
}

    /**
     * Logout the specified resource.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'message'       => 'Logout',
            'success' => 'Logout successfully',
        ];

        return $response;
    }
}
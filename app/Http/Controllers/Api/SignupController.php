<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;


class SignupController extends Controller
{
    // public function showSignupForm()
    // {
    //     return view('signup');
    // }

    public function signup(SignupRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $validated["password"] = Hash::make($validated["password"]);

        $user = User::create($validated);
        $user->role = 'user';

        return $user;
    }

//     public function signup(SignupRequest $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|string|min:6|confirmed',
//         ]);

//         $user = new User([
//             'name' => $request->input('name'),
//             'email' => $request->input('email'),
//             'password' => Hash::make($request->input('password')),
//         ]);

//         // Assign the 'user' role
//         $user->role = 'user';

//         $user->save();

//         // You may also want to authenticate the user at this point

//         return $user; // Redirect to the login page
//     }

// 
}
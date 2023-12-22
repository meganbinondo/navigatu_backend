<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return User::all();
    // }

    public function index()
    {
        // Assuming you have a 'role' column in your 'users' table
        $customers = User::where('role', 'customer')->get();

        return $customers;
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    { 


        // Retrieve the validated input data...
    $validated = $request->validated();

    // Set a default role if it is not provided
    $validated['role'] = $validated['role'] ?? 'customer';

    // Hash the password
    $validated["password"] = Hash::make($validated["password"]);

    // Create the user with the specified role
    $user = User::create($validated);

    return response()->json([
        'success' => 'User successfully registered.',
        'data' => $user,
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrfail($id);
    }
    

    /**
     * Update the specified resource in storage.
     */
    // public function update(UserRequest $request, string $id)
    // {
    //     // Retrieve the validated input data...
    //     $validated = $request->validated();

    //     $carouselItem = User::findOrfail($id);

    //     $carouselItem->update($validated);

    //     return $carouselItem;
    // }

    /**
     * Update the specified name, email and password resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrfail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();
 
        $user->name = $validated['name'];
        
        $user->save();

        return $user;
    }

    public function email(UserRequest $request, string $id)
    {
        $user = User::findOrfail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();
 
        $user->email = $validated['email'];
        
        $user->save();

        return $user;
    }

    public function password(UserRequest $request, string $id)
    {
        $user = User::findOrfail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();
 
        // $user->password = Hash::make($validated["password"]);
        
        // $user->save();


        // Check if 'password' key exists before updating it
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $user->save();
        }


        return $user;
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail($id);
 
        $user->delete();

        return $user;
    }

    public function MyAccount()
    {
        $user = Auth::user();

        // Assuming you have a 'role' column in your 'users' table
        $userData = User::where('id', $user->id)->first();

        return response()->json([
            'data' => $userData,
            'message' => 'User information retrieved successfully.',
        ]);
    }
}

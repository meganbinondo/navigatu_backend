<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\EventRemarksController;
use App\Http\Controllers\Api\AuthController;
use App\Models\EventRemarks;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes for customer signup and login

Route::post('/login', [AuthController::class, 'login'])->name('customer.login');
Route::post('/user', [UserController::class, 'store'])->name('user.store');     //User Signup

// Customer routes (accessible only after login)
Route::middleware(['auth:sanctum', 'customer'])->group(function () {

    Route::get('/customer/dashboard', 'CustomerController@dashboard');


});

// Admin routes (accessible only to admins)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::get('/admin/dashboard', 'AdminController@dashboard');
    

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index');
    Route::get('/user/{id}', 'show');
    Route::put('/user/{id}', 'update')->name('user.update');
    Route::put('/user/email/{id}', 'email')->name('user.email');
    Route::delete('/user/{id}', 'destroy');
});


Route::controller(AppointmentController::class)->group(function () {
    
   
    Route::get('/allappointment', 'showall');
    Route::post('/appointment/{id}/accept', 'accept')->name('appointment.accept');
    Route::post('/appointment/{id}/decline', 'decline')->name('appointment.decline');
});
});


// Common routes (accessible only to both)
Route::middleware(['auth:sanctum', 'common'])->group(function () {
    Route::get('/common/dashboard', 'CommonController@dashboard');
    
    Route::get('/logout', [AuthController::class, 'logout']);
    
    Route::put('/user/password/{id}', [UserController::class, 'password'])->name('user.password');
    
    Route::resource('appointment', AppointmentController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    
    Route::get('/eventremarks', [EventRemarksController::class, 'index']);
    
    Route::get('/myaccount', [UserController::class, 'MyAccount']);
});
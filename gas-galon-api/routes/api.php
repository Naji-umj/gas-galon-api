<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PaymentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/register', [AuthController::class, 'register']);  
Route::post('/login', [AuthController::class, 'login']);        

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);  


    Route::get('/products', [ProductController::class, 'index']);        
    Route::get('/products/{id}', [ProductController::class, 'show']);    
    Route::post('/products', [ProductController::class, 'store']);       
    Route::put('/products/{id}', [ProductController::class, 'update']);  
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); 


    Route::get('/orders', [OrderController::class, 'index']);             
    Route::get('/orders/{id}', [OrderController::class, 'show']);         
    Route::post('/orders', [OrderController::class, 'store']);            
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']); 
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);   


    Route::get('/order-details', [OrderDetailController::class, 'index']);       
    Route::get('/order-details/{id}', [OrderDetailController::class, 'show']);   
    Route::post('/order-details', [OrderDetailController::class, 'store']);      
    Route::put('/order-details/{id}', [OrderDetailController::class, 'update']); 
    Route::delete('/order-details/{id}', [OrderDetailController::class, 'destroy']); 


    Route::get('/payments', [PaymentController::class, 'index']);        
    Route::get('/payments/{id}', [PaymentController::class, 'show']);    
    Route::post('/payments', [PaymentController::class, 'store']);       
    Route::put('/payments/{id}', [PaymentController::class, 'update']);  
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy']); 

});

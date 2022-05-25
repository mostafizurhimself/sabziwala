<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AjaxController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FeatureProductController;
use App\Http\Controllers\Api\TestimonialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ajax Route
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/{product}/auth', [ProductController::class, 'showForAuth'])->middleware(['assign.guard:customers', 'jwt.auth']);
Route::get('/categories', [AjaxController::class, 'category']);
Route::get('/tags', [AjaxController::class, 'tag']);
Route::post('/customers/check', [AjaxController::class, 'checkCustomer']);

// Other routes
Route::get('/config', ConfigController::class);
Route::get('/countries', [AjaxController::class, 'country']);
Route::apiResource('orders', OrderController::class)->only('index', 'show', 'store');
Route::get('/orders/assigned/get', [OrderController::class, 'assignedOrders']);
Route::get('/orders/delivered/get', [OrderController::class, 'deliveredOrders']);
Route::get('/orders/{order}/assigned', [OrderController::class, 'showAssigned']);
Route::patch('/orders/{order}/update', [OrderController::class, 'updateAssigned']);
Route::get('/riders-home', [OrderController::class, 'ridersHome']);
Route::get('/riders', RiderController::class);
Route::get('/zones', ZoneController::class);
Route::get('/feature-products', FeatureProductController::class);
Route::get('/testimonial', TestimonialController::class);

// Review Routes
Route::post('/order-items/{orderItem}/reviews', [ReviewController::class, 'store']);
Route::post('/contacts', ContactController::class);

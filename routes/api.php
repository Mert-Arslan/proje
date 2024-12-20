<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TransactionController;




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

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::post('/user/{id}/subscription', [SubscriptionController::class, 'Subs']);
Route::put('/user/{user_id}/subscription/{subscription_id}', [SubscriptionController::class, 'SubsUpdate']);
Route::delete('/user/{id}/subscription/{subscription_id}', [SubscriptionController::class, 'SubDelete']);
Route::post('/user/{id}/transaction', [TransactionController::class, 'TransactionFunc']);

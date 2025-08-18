<?php

use App\Http\Controllers\api\DealerController;
use App\Http\Controllers\api\ExecutivesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {

//Dealers
Route::post('/dealers', [DealerController::class, 'store']);
Route::put('/dealers/{id}', [DealerController::class, 'update']);
Route::delete('/dealers/{id}', [DealerController::class, 'destroy']);
Route::get('/states', [DealerController::class, 'state']);
Route::get('/districts/{id}', [DealerController::class, 'getDistricts']);

//Executives
Route::post('/executives', [ExecutivesController::class, 'store']);
Route::put('executives/{id}', [ExecutivesController::class, 'update']);
Route::delete('executives/{id}', [ExecutivesController::class, 'destroy']);
// });

<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// routes/api.php

Route::apiResource('categories', CategoryController::class);
Route::get('categories2', [CategoryController::class, 'sorted'])->name('categories_sorted');

Route::apiResource('products', ProductController::class);
Route::post('products/{product}/add-asset', [ProductController::class, 'addAssets']);
Route::get('products2', [ProductController::class, 'indexByPriceDescending'])->name('products_sorted');
Route::put('products/{product}/edit', [ProductController::class, 'edit']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);
Route::delete('products/assets/{asset}', [ProductController::class, 'removeAsset']);

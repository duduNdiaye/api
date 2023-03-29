<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProduitController;

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

Route::group(["middleware" => ["auth:sanctum"]], function () {

    Route::post('/produits', [ProduitController::class, 'store']);

    Route::put('/produits/{id}', [ProduitController::class, 'update']);
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);
    Route::post('user/deconnexion', [UserController::class, "deconnexion"]);
});

Route::get("/", function () {
    return "Hello WORLD";
});

Route::post('user/inscription', [UserController::class, "inscription"]);
Route::post('user/connexion', [UserController::class, "connexion"]);
Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/{id}', [ProduitController::class, 'show']);

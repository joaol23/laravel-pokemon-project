<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'auth'])
    ->name('login');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('/user', UserController::class);
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

Route::get('/pokemons', [PokemonController::class, 'index'])
    ->name('pokemon.list');

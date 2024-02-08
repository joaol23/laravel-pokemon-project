<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPokemonController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\OnlyChangeCurrentUser;
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
Route::prefix('/auth')
    ->group(function () {
        Route::post('/login', [AuthController::class, 'auth'])
            ->name('login');
        Route::post('/register', [AuthController::class, 'register'])
            ->name('register');
    });

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::prefix('/auth')
            ->group(function () {
                Route::post('/logout', [AuthController::class, 'logout'])
                    ->name('logout');
                Route::get('/me', [AuthController::class, 'me'])
                    ->name('about.me');
            });
        Route::middleware(OnlyChangeCurrentUser::class)
            ->group(function () {
                Route::apiResource('/user', UserController::class);
                Route::prefix("/user")
                    ->group(function () {
                        Route::post('/{user}/pokemon/{pokemon}', [UserPokemonController::class, 'addPokemon'])
                            ->name('user.add.pokemon');
                        Route::delete('/{user}/pokemon/{order}', [UserPokemonController::class, 'removePokemon'])
                            ->name('user.remove.pokemon');
                        Route::get('/{user}/pokemons', [UserPokemonController::class, 'listPokemons'])
                            ->name('user.list.pokemon');
                        Route::post('/{user}/photo', [UserProfileController::class, 'saveProfile'])
                            ->name('user.photo');
                    });
            });
    });

Route::get('/pokemons', [PokemonController::class, 'index'])
    ->name('pokemon.list');
Route::get('/pokemon/{name}', [PokemonController::class, 'details'])
    ->name('pokemon.details');

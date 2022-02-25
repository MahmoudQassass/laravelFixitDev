<?php

use App\Http\Controllers\APIControllers\fixitAPIAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:'.config('fortify.guard'),
    ]));

Route::post('/register', [\Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'store'])
    ->middleware(['guest:'.config('fortify.guard')]);

Route::post('/auth/register', [fixitAPIAuthController::class, 'register']);

Route::post('/auth/login', [fixitAPIAuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });

    Route::post('/auth/logout', [fixitAPIAuthController::class, 'logout']);
});

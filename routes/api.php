<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function () {

    $name = \request('name');
    $email = \request('email');

    return response([
//        'data' => [
//            'name' => $name,
//            'email' => $email
//        ]

        'data' => \request()->all()
    ], 200);
});

//Route::delete('/{role}',[\App\Http\Controllers\RoleController::class, 'destroy'])
//    ->middleware(CheckAccessMiddleware::class,':delete-roles');


Route::get('/artists', [\App\Http\Controllers\ArtistController::class, 'index']);


Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);


/*Register*/
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store']);
/*END.Register*/
/*Login*/
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store']);
/*END.Login*/

Route::get('/concerts',[\App\Http\Controllers\ConcertController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    /*Logout*/
    Route::delete('/logout', [\App\Http\Controllers\LoginController::class, 'destroy']);
    /*END.Logout*/

    Route::post('/artists', [\App\Http\Controllers\ArtistController::class, 'store']);
    Route::get('/artists/{artist}', [\App\Http\Controllers\ArtistController::class, 'show']);
    Route::patch('/artists/{artist}', [\App\Http\Controllers\ArtistController::class, 'update']);
    Route::delete('/artists/{artist}', [\App\Http\Controllers\ArtistController::class, 'destroy']);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show']);


    Route::get('/seat-classes',[\App\Http\Controllers\SeatClassController::class, 'index']);




    Route::prefix('/categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
        Route::post('/store', [\App\Http\Controllers\CategoryController::class, 'store'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ':create-categories');
        Route::patch('/{category}', [\App\Http\Controllers\CategoryController::class, 'update']);
        Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
    });


    Route::get('/halls',[\App\Http\Controllers\HallController::class, 'index']);
    Route::get('/halls/{hall}',[\App\Http\Controllers\HallController::class, 'show']);




    Route::prefix('/roles')->group(function () {
        Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ':read-roles');

        Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ':create-roles');

        Route::patch('/{role}', [\App\Http\Controllers\RoleController::class, 'update'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ":update-roles");

        Route::get('/{role}', [\App\Http\Controllers\RoleController::class, 'show'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ':read-roles');

        Route::delete('/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
            ->middleware(\App\Http\Middleware\CheckAccessMiddleware::class . ':delete-roles');
    });

    Route::post('/concerts/store',[\App\Http\Controllers\ConcertController::class, 'store']);
    Route::delete('/concerts/{concert}',[\App\Http\Controllers\ConcertController::class, 'destroy']);



    Route::post('/halls/store',[\App\Http\Controllers\HallController::class, 'store']);
    Route::patch('/halls/{hall}',[\App\Http\Controllers\HallController::class, 'update']);
    Route::delete('/halls/{hall}',[\App\Http\Controllers\HallController::class, 'destroy']);

    Route::post('/halls/{hall}/seats/store',[\App\Http\Controllers\HallSeatController::class, 'store']);
    Route::get('/halls/{hall}/seats',[\App\Http\Controllers\HallSeatController::class, 'index']);
    Route::patch('/halls/{hall}/seats',[\App\Http\Controllers\HallSeatController::class, 'update']);

});

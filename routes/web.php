<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin' ], function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');

    Route::group(['prefix' => 'movie'], function() {
        Route::get('/movie', [MovieController::class, 'index']);
        Route::get('/movie/create', [MovieController::class, 'create']);

        
    });

    
    
});



// Route::get('/', function () {
//     return view('welcome');
// });

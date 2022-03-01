<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidateApiController;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});


Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'preventBackHistory']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('candidate', CandidateController::class);
});


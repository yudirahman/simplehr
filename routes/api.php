<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiCandidateController;
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

Route::group([
    'prefix'    => 'v1',
    'as'        => 'api.',
    'middleware'=> ['auth:api']    
],function (){
    Route::get('/all-candidate', [ApiCandidateController::class, 'allCandidate']);
    Route::get('/detail-candidate/{id}', [ApiCandidateController::class, 'detailCandidate']);
    Route::middleware(['role:Admin|Senior HRD'])->group(function(){
        Route::post('/store-candidate', [ApiCandidateController::class, 'storeCandidate']);
        Route::post('/update-candidate/{id}', [ApiCandidateController::class, 'updateCandidate']);
    });
    Route::middleware(['role:Admin'])->delete('/delete-candidate/{id}', [ApiCandidateController::class, 'deleteCandidate']);
});


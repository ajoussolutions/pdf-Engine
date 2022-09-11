<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HtmlTemplateController;

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



    Route::post('/render',[HtmlTemplateController::class,'PrintCustom'])->name('customrender');
    Route::get('/preview',[HtmlTemplateController::class,'PrintPreview'])->name('getpreview');
    Route::post('/render/template/{template}',[HtmlTemplateController::class,'Print'])->name('templaterender');



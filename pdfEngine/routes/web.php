<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HtmlTemplateController;

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
    return view('welcome');
});

Route::get('template/{templatename}/edit',[HtmlTemplateController::class,'Edit'])->name('edittemplate');
Route::post('template/{templatename}/edit',[HtmlTemplateController::class,'Save'])->name('savetemplate');
Route::get('templates',[HtmlTemplateController::class,'List'])->name('templatelist');
Route::get('templates/new',function(){
    return View('templates.new');
})->name('newtemplate');
Route::post('templates/new',[HtmlTemplateController::class,'Create'])->name('createtemplate');

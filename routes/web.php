<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/word',[HomeController::class,'generateDocx']);

Route::get('users', [UserController::class,'index']);
Route::get('users/{id}', [UserController::class,'show']);
Route::get('users/word-export/{id}', [UserController::class,'wordExport']);
Route::get('users/pdf-export/{id}', [UserController::class,'pdfExport']);
Route::get('users/excel-export', [UserController::class,'ExcelExport']);

Route::get('/exceExport',[UserController::class,'ExcelExport']);
Route::get('/exceImport',function(){return view('users.import');});
Route::post('/exceImport',[UserController::class,'ExcelImport'])->name("excel.import");

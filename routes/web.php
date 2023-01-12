<?php

use App\Http\Controllers\CompaniesController;
use Illuminate\Support\Facades\Route;

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

Route::post('/company/store',[App\Http\Controllers\CompaniesController::class,'store'])->name('company.store');
Route::get('/company/create',[App\Http\Controllers\CompaniesController::class,'create'])->name('company.create');
Route::post('/getAddress',[App\Http\Controllers\CompaniesController::class,'search'])->name('getAddress');

Route::get('/company',[App\Http\Controllers\CompaniesController::class,'index'])->name('company.index');

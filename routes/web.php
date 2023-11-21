<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    // User needs to be authenticated to enter here.
    Route::get('/dashboard', [UserController::class,'dashboard']);

    Route::get('/get-expense', [ExpenseController::class,'getExpenses'])->name('expenses.get.expense');
    Route::post('/import-expenses', [ExpenseController::class,'importExpensesFromCSV'])->name('import.expenses'); 
    Route::resource('expenses',ExpenseController::class);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

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

// index
Route::get('/', [CalculatorController::class, 'index']);

// update currency values
Route::get('/update', [CalculatorController::class, 'update']);

// get currencies
Route::post('/currencies', [CalculatorController::class, 'currency']);

// calculate
Route::post('/calc', [CalculatorController::class, 'calc']);

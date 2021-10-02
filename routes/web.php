<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRequestController;

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

Route::redirect('/', '/login');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Auth::routes();

Route::get('list/companies', [UserRequestController::class, 'listCompanies']);
Route::get('list/plants/{id}', [UserRequestController::class, 'listPlants']);
Route::get('list/costcenter/{id}', [UserRequestController::class, 'listCostCenter']);
Route::get('list/approvers/{id}', [UserRequestController::class, 'listApprovers']);
Route::get('list/status', [UserRequestController::class, 'listStatuses']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('requests', UserRequestController::class);
});
<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', WelcomeController::class);
// can be replaced by:
Route::resource('/contacts', ContactController::class);
Route::delete('/contacts/{contact}/restore', [ContactController::class, 'restore'])->name('contacts.restore')->withTrashed();
Route::delete('/contacts/{contact}/force-delete', [ContactController::class, 'forceDelete'])->name('contacts.force-delete')->withTrashed();


Route::resource('/companies', CompanyController::class);
Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class
]);
Route::resource('/activities', ActivityController::class)->except([
    'index', 'show' // only allow functions that aren't specified
]);
Route::resource('/contacts.notes', ContactController::class);
// Route::resource('/activities', ActivityController::class)->names([
//     'index' => 'activities.all',
//     'show' => 'activities.view'
// ]);
Route::resource('/activities', ActivityController::class)->parameters([
    'activities' => 'active'
]);
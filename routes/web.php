<?php

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

Route::get('/contacts', function () {
    return "<h1>All contacts</h1>";
});

Route::get('/contacts/create', function () {
    return "<h1>Add new contact</h1>";
});

// parameter
Route::get('/contacts/{id}', function ($id) {
    return "Contact " . $id;
})->whereNumber('id');  // => format so only numbers are allowed || alternative: ->where('id', '[0-9]+')

// optional parameter (default value)
Route::get('/companies/{name?}', function ($name = null) {
    if ($name) {
        return "Company " . $name;
    } else {
        return "All Companies";
    }
})->whereAlpha('name'); // => format so only alphabetic characters are allowed || alternative: ->where('name', '[a-zA-Z]+')

// ->whereAlphaNumeric allows both numbers and alphabetic characters
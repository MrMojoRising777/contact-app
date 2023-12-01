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

function getContacts() {
    return [
        1 => ['name' => 'Name 1', 'phone' => '123456789'],
        2 => ['name' => 'Name 2', 'phone' => '987654321'],
        3 => ['name' => 'Name 3', 'phone' => '147258369'],
    ];
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contacts', function () {
    $contacts = getContacts();
    return view('contacts.index', compact('contacts')); // alternative to compact(): ['contacts' => $contacts]
})->name('contacts.index');

Route::get('/contacts/create', function () {
    return view('contacts.create');
})->name('contacts.create');

Route::get('/contacts/{id}', function ($id) {
    $contacts = getContacts();
    abort_if(!isset($contacts[$id]), 404); // if id does not exist in contacts[], give 404 error | alternative: abort_unless($contacts[$id], 404)
    $contact = $contacts[$id];
    return view('contacts.show')->with('contact', $contact);
})->name('contacts.show');
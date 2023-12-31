<?php

use App\Models\User;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportContactcontroller;
use App\Http\Controllers\ImportContactcontroller;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class);
    Route::get('/settings/profile-information', ProfileController::class)->name('user-profile-information.edit');
    Route::get('/settings/password', PasswordController::class)->name('user-password.edit');
    Route::get('/sample-contacts', function (){
        return response()->download(Storage::path('contacts-sample.csv'));
    })->name('sample-contacts');
    Route::get('/contacts/import', [ImportContactcontroller::class, 'create'])->name('contacts.import.create');
    Route::post('/contacts/import', [ImportContactcontroller::class, 'store'])->name('contacts.import.store');
    Route::get('/contacts/export', [ExportContactcontroller::class, 'create'])->name('contacts.export.create');
    Route::post('/contacts/export', [ExportContactcontroller::class, 'store'])->name('contacts.export.store');
    Route::resource('/contacts', ContactController::class);
    Route::delete('/contacts/{contact}/restore', [ContactController::class, 'restore'])->name('contacts.restore')->withTrashed();
    Route::delete('/contacts/{contact}/force-delete', [ContactController::class, 'forceDelete'])->name('contacts.force-delete')->withTrashed();

    Route::resource('/companies', CompanyController::class);
    Route::delete('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore')->withTrashed();
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])->name('companies.force-delete')->withTrashed();
    Route::resources([
        '/tags' => TagController::class,
        '/tasks' => TaskController::class
    ]);
    Route::resource('/activities', ActivityController::class)->except([
        'index', 'show'
    ]);
    Route::resource('/contacts.notes', ContactController::class);
    Route::resource('/activities', ActivityController::class)->parameters([
        'activities' => 'active'
    ]);
}); 

Route::get('/download', function() {
    return Storage::download('PNG.png', 'custom-file-name.png');
});

Route::get('/eagerload-multiple', function() {
    $users = User::with(['companies', 'contacts'])->get();

    foreach($users as $user) {
        echo $user->name . ": ";
        echo $user->companies->count() . " companies, " . $user->contacts->count() . " contacts<br>";
    }
});

Route::get('/eagerload-nested', function() {
    $users = User::with(['companies', 'companies.contacts'])->get();

    foreach ($users as $user) {
        echo $user->name . "<br />";
        foreach ($user->companies as $company) {
            echo $company->name . " has " . $company->contacts->count() . " contacts <br />";
        }
        echo "</br />";
    }
});

Route::get('/eagerload-constrained', function() {
    $users = User::with(['companies' => function($query) {
        $query->where('email', 'like', '%.org');
    }])->get();

    foreach ($users as $user) {
        echo $user->name . "<br />";
        foreach ($user->companies as $company) {
            echo $company->email . "<br />";
        }
        echo "</br />";
    }
});

Route::get('/eagerload-lazy', function() {
    $users = User::get();
    $users->load(['companies' => function($query) {
        $query->orderBy('name');
    }]);

    foreach ($users as $user) {
        echo $user->name . "<br />";
        foreach ($user->companies as $company) {
            echo $company->name . "<br />";
        }
        echo "</br />";
    }
});

Route::get('/eagerload-default', function() {
    $users = User::select(['name', 'email'])->without('contacts')->get();

    foreach ($users as $user) {
        echo $user->name . "<br />";
        // foreach ($user->companies as $company) {
        //     echo $company->email . "<br />";
        // }
        echo "</br />";
    }
});

Route::get('/count-models', function() {
    // $users = User::withCount([
    //     'contacts as contacts_number',
    //     'companies as companies_count_end_with_gmail' => function($query) {
    //         $query->where('email', 'like', '%@gmail.com');
    //     }
    // ])->get();

    // foreach ($users as $user) {
    //     echo $user->name . "<br />";
    //     echo $user->companies_count_end_with_gmail . " companies<br />";
    //     echo $user->contacts_number . " contacts<br />";
    //     echo "</br />";
    // }

    $users = User::get();
    $users->loadCount(['companies' => function ($query) {
        $query->where('email', 'like', '%@gmail.com');
    }]);

    foreach ($users as $user) {
        echo $user->name . "<br />";
        echo $user->companies_count . " companies<br />";
        echo "</br />";
    }
});
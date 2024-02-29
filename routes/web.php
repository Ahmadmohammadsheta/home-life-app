<?php

// namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//-----------------------------------------------------------------------------------------------------------
// Route::prefix("main_projects")->group(function () {
//     Route::resource('/', MainProjectController::class);
//     Route::controller(MainProjectController::class)->group(function () {
//         Route::get('/show', 'show')->name('users.show');
//     });
// });

//______________________________________________________________________________________________________________________


//-----------------------------------------------------------------------------------------------------------
// Route::group(['prifex' => 'main_projects', 'as' => 'main_projects.' , 'namespace' => 'App\Http\Controllers'], function() {
Route::group(['prifex' => 'main_projects', 'as' => 'main_projects.'], function() {
    Route::resource('/main_projects', 'MainProjectController');
    // Route::get('/', 'yes')->name('yes');
});

//______________________________________________________________________________________________________________________



//-----------------------------------------------------------------------------------------------------------
Route::name('socialite.')->controller(App\Http\Controllers\SocialiteController::class)->group(function () {
    Route::get('{provider}/login', 'login')->name('login');
    Route::get('{provider}/redirect', 'redirect')->name('redirect');
});
//______________________________________________________________________________________________________________________




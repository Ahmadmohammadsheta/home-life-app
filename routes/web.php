<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\LoginNotification;
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
    $user = auth()->user();
    $user->notify(new LoginNotification());
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//-----------------------------------------------------------------------------------------------------------
Route::name('socialite.')->controller(App\Http\Controllers\packeges\SocialiteController::class)->group(function () {
    Route::get('{provider}/login', 'login')->name('login');
    Route::get('{provider}/redirect', 'redirect')->name('redirect');
});
//______________________________________________________________________________________________________________________



//-----------------------------------------------------------------------------------------------------------
// Route::group(['prifex' => 'main_projects', 'as' => 'main_projects.' , 'namespace' => 'App\Http\Controllers'], function() {
Route::group(['prifex' => 'main_projects', 'as' => 'main_projects.'], function() {
    Route::resource('/main_projects', 'MainProjectController');
    // Route::get('/', 'yes')->name('yes');
});

//______________________________________________________________________________________________________________________




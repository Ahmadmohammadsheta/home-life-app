<?php
namespace App\Http\Controllers;
use App\Http\Controllers\CategoryController;
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

Route::get('/dashboard', function () {
    // $user = auth()->user(); // worked
    // $user->notify(new LoginNotification());
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    //-----------------------------------------------------------------------------------------------------------
    Route::resource('/types', 'TypeController');
    Route::controller(TypeController::class)->group(function () {
        Route::get('types/trashed', 'trashed')->name('types.trashed');
        Route::put('types/{category}/restore', 'restore')->name('types.restore')->where('category', '\d+'); // \d its mean any digit + mean more 111111
        Route::delete('types/{category}/force-delete', 'forceDelete')->name('types.force-delete');
    });
    //______________________________________________________________________________________________________________________

    //-----------------------------------------------------------------------------------------------------------
    Route::resource('/projects', 'ProjectController');
    //______________________________________________________________________________________________________________________

    //-----------------------------------------------------------------------------------------------------------
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories/trashed', 'trashed')->name('categories.trashed');
        Route::put('categories/{category}/restore', 'restore')->name('categories.restore')->where('category', '\d+'); // \d its mean any digit + mean more 111111
        Route::delete('categories/{category}/force-delete', 'forceDelete')->name('categories.force-delete');
    });
    Route::resource('categories', 'CategoryController');
    //______________________________________________________________________________________________________________________
});

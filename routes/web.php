<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterAuthController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;

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

Route::controller(LoginRegisterAuthController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users-list', 'users')->name('users-list');
    Route::post('/logout', 'logout')->name('logout');
    Route::put('/update-profile/{id}', 'updateProfile')->name('update-profile');
    Route::get('/edit-profile/{id}', 'editProfile')->name('edit-profile');
    Route::delete('/delete-photos/{id}', 'deletePhotos')->name('delete-photos');
   });

Route::resource('gallery', GalleryController::class);
Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');

Route::get('/send-mail', [SendEmailController::class, 'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');
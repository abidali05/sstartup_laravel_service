<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

Route::get('/clear', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cleared";
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['verify' => true, 'login' => false, 'register' => false]);

Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/user/sign_in', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/user/sign_in', [LoginController::class, 'login']);

Route::get('/user/signup', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/user/signup', [RegisterController::class, 'register']);

Route::group(
    ['prefix' => "/dashboard/", "middleware" => ["auth", 'verified']],
    function () {
        Route::get('', [HomeController::class, 'index'])->name('auth');

        Route::get('my-profile', [UserController::class, 'editProfile'])->name('myProfile');
        Route::put('edit-my-profile', [UserController::class, 'updateMyProfile'])->name('updateMyProfile');

        // change password
        Route::get('/settings', [HomeController::class, 'changePassword'])->name('change_password');
        Route::post('/change-password/update', [HomeController::class, 'updatePassword'])->name('update_password');

        // Document dashboard

        Route::controller(DocumentController::class)
            ->prefix('documents/')
            ->as('document.')
            ->group(function () {
                Route::get('index', 'index')->name('index');
                Route::get('create', 'create')->name('upload');
                Route::post('store', 'store')->name('store');
                Route::get('show/{id}', 'show')->name('show');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
            });

        // End Document dashboard

        Route::group(
            ["middleware" => "role:admin"],
            function () {
                Route::resource('users', UserController::class)->middleware('isAdmin');
            }
        );
    }
);

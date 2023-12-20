<?php

use App\Http\Controllers\Auth\LoginController as DefaultLoginController;
use App\Http\Controllers\loginController as LoginController;
use App\Http\Controllers\mainController as MainController;
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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login-action', [LoginController::class, 'loginAction'])->name('login-action');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-user', [LoginController::class, 'registerUser'])->name('register-user');
Route::post('/check-username', [LoginController::class, 'checkUsername'])->name('check-username');
Route::post('/check-email', [LoginController::class, 'checkEmail'])->name('check-email');
Route::group(['middleware' => 'checkUserLoggedIn'], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::post('send-msg', [MainController::class, 'sendMsg'])->name('send-msg');
    Route::post('/send-messasge', [MainController::class, 'SendMessageAjax'])->name('send-messasge');
    // Route::get('/{user}', [MainController::class, 'userChats'])->name('user-chats');
    Route::get('/get-message/{id}/{username}', [MainController::class, 'getMessage'])->name('get-message');
    Route::get('/get-message-realtime/{id}/{username}', [MainController::class, 'getMessageRealtime'])->name('get-message-realtime');
    Route::get('/search-user/{username}', [MainController::class, 'searchUser'])->name('search-user');
    Route::post('/send-request', [MainController::class, 'sendRequest'])->name('send-request');
    Route::post('/accept-reject-request', [MainController::class, 'acceptRejectRequest'])->name('accept-reject-request');
});

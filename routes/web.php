<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
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
    return view('todo-home');
});

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::view('registration', 'auth.registration')->name('registration');
    Route::post('registration', [AuthController::class, 'store'])->name('registration.store');
});

Route::middleware('auth')->group(function () {
    Route::resource('todos', TodoController::class);
    Route::get('todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


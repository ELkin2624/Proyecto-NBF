<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//lleva al login
Route::get('/', function () {
    return redirect()->route('login'); // Redirige al login cuando visiten la raíz
});

// Ruta para la selección de tipo de cuenta
Route::get('/select-account', function () {
    return Inertia::render('SelectAccountType');
})->name('select-account');

// Rutas para el login de Admin y Cliente
Route::get('/login/admin', function () {
    return Inertia::render('Auth/AdminLogin'); // Vista para Admin
})->middleware('guest')->name('login.admin');

Route::get('/login/client', function () {
    return Inertia::render('Auth/CLientLogin'); // Vista para Cliente
})->middleware('guest')->name('login.client');


/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/


// Rutas para la recuperación de contraseñas
Route::get('forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword'); // Asegúrate de que tienes esta vista
})->middleware('guest')->name('password.request');

Route::post('forgot-password', [\Laravel\Fortify\Http\Controllers\PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('reset-password/{token}', function ($token) {
    return Inertia::render('Auth/ResetPassword', ['token' => $token]); // Asegúrate de que tienes esta vista
})->middleware('guest')->name('password.reset');

// Ruta para actualizar la contraseña
Route::post('reset-password', [\Laravel\Fortify\Http\Controllers\NewPasswordController::class, '__invoke'])->middleware('guest')->name('password.update');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\NotaCompraController;


//19/10
Route::get('/', function () {
    return Inertia::render('RoleSelection');
});

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

// Rutas para gestionar roles y usuarios
Route::get('/users', [UsuarioController::class, 'index'])->middleware('auth')->name('users');
Route::post('/users', [UsuarioController::class, 'store'])->middleware('auth');
Route::put('/users/{id_usuario}', [UsuarioController::class, 'update'])->middleware('auth');
Route::delete('/users/{id_usuario}', [UsuarioController::class, 'destroy'])->middleware('auth');
Route::post('/audit/report', [UsuarioController::class, 'generateReport'])->middleware('auth');

// Rutas para gestionar el almacen
Route::get('/almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
Route::get('/almacenes/create', [AlmacenController::class, 'create'])->name('almacenes.create');
Route::post('/almacenes', [AlmacenController::class, 'store'])->name('almacenes.store');
Route::get('/almacenes/{id}/edit', [AlmacenController::class, 'edit'])->name('almacenes.edit');
Route::put('/almacenes/{id}', [AlmacenController::class, 'update'])->name('almacenes.update');
Route::delete('/almacenes/{id}', [AlmacenController::class, 'destroy'])->name('almacenes.destroy');

//Rutas para gestionar inventario
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
    Route::post('/inventario/store', [InventarioController::class, 'store'])->name('inventario.store');
});

//Rutas para gestionar productos
Route::middleware('auth')->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{codigo}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{codigo}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{codigo}', [ProductoController::class, 'destroy'])->name('productos.destroy');
 });

 //Rutas para reportes
 Route::get('/reportes/inventario', function () {
    return Inertia::render('Reportes/ReporteInv');
})->name('reportes.inventario.view');

// Rutas para gestión de proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index'); // Listado de proveedores
Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store'); // Crear nuevo proveedor
Route::put('/proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update'); // Actualizar proveedor
Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy'); // Eliminar proveedor

//Rutas para gestion de nota de compra
Route::get('/nota-compra', [NotaCompraController::class, 'index'])->name('nota-compra.index');
Route::get('/nota-compra/create', [NotaCompraController::class, 'create'])->name('nota-compra.create');
Route::post('/nota-compra', [NotaCompraController::class, 'store'])->name('nota-compra.store');


// Ruta opcional para dashboard genérico si no hay diferenciación de roles
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

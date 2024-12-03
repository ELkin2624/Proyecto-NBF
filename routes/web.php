<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
//Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoVistaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\NotaCompraController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\NotaVentaController;
use App\Http\Controllers\PedidoController;


Route::get('/', [ProductoVistaController::class, 'index'])->name('vistap.index');

// Rutas públicas
Route::middleware('guest')->group(function () {
    //ruta de RoleSlection
    Route::get('/role-selection', function () {return Inertia::render('RoleSelection');})->name('role-selection');

    // Recuperación de contraseña
    Route::get('forgot-password', fn() => Inertia::render('Auth/ForgotPassword'))->name('password.request');
    Route::post('forgot-password', [\Laravel\Fortify\Http\Controllers\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', fn($token) => Inertia::render('Auth/ResetPassword', ['token' => $token]))->name('password.reset');
    Route::post('reset-password', [\Laravel\Fortify\Http\Controllers\NewPasswordController::class, '__invoke'])->name('password.update');

    // Vista de productos
    Route::get('/vistaproductos/{codigo}', [ProductoVistaController::class, 'show'])->name('vistap.show');
});

// Rutas para admins
Route::middleware(['auth', 'role:admin'])->group(function () {
     // Dashboard del admin
     Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    //Rutas para gestionar roles y usuarios
    Route::get('/users', [UsuarioController::class, 'index'])->name('users');
    Route::post('/users', [UsuarioController::class, 'store']);
    Route::put('/users/{id_usuario}', [UsuarioController::class, 'update']);
    Route::delete('/users/{id_usuario}', [UsuarioController::class, 'destroy']);
    Route::post('/audit/report', [UsuarioController::class, 'generateReport']);

    //Ruta para bitacora
    Route::get('/Bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::post('/registro-accion', [BitacoraController::class, 'registrarAccion']);

    // Rutas para gestionar el almacen
    Route::get('/almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::get('/almacenes/create', [AlmacenController::class, 'create'])->name('almacenes.create');
    Route::post('/almacenes', [AlmacenController::class, 'store'])->name('almacenes.store');
    Route::get('/almacenes/{id}/edit', [AlmacenController::class, 'edit'])->name('almacenes.edit');
    Route::put('/almacenes/{id}', [AlmacenController::class, 'update'])->name('almacenes.update');
    Route::delete('/almacenes/{id}', [AlmacenController::class, 'destroy'])->name('almacenes.destroy');

    //Rutas para gestionar el inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
    Route::get('/inventario/{id}/editar', [InventarioController::class, 'edit'])->name('inventario.update');
    Route::post('/inventario/store', [InventarioController::class, 'store'])->name('inventario.store');

    //Rutas para gestionar productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{codigo}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::post('/productos/{codigo}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{codigo}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Rutas para gestión de proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index'); // Listado de proveedores
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store'); // Crear nuevo proveedor
    Route::put('/proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update'); // Actualizar proveedor
    Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy'); // Eliminar proveedor

    // Gestión de notas de compra
    Route::resource('/notas-compra', NotaCompraController::class)->except(['show']);
    Route::put('/notas-compra/{nota_compra}/recepcion', [NotaCompraController::class, 'registrarRecepcion'])->name('notas-compra.recepcion');
    Route::get('/notas-compra/{id}/historial', [NotaCompraController::class, 'historial'])->name('notas-compra.historial');
    Route::post('/notas-compra/{id}/recibir', [NotaCompraController::class, 'recibirProductos'])->name('nota-compra.recibir');
    Route::get('/alertas', [AlertaController::class, 'index']);
    Route::get('/reporte-notas-compra', [NotaCompraController::class, 'generarReporte'])->name('notas-compra.reporte');

    // Gestión de notas de venta
    Route::get('/notas-venta', [NotaVentaController::class, 'index'])->name('notas-venta.index');
    Route::get('/notas-venta/create', [NotaVentaController::class, 'create'])->name('notas-venta.create');
    Route::post('/notas-venta', [NotaVentaController::class, 'store'])->name('notas-venta.store');
    Route::get('/notas-venta/{id}', [NotaVentaController::class, 'show'])->name('notas-venta.show');
    Route::put('/notas-venta/{id}/estado', [NotaVentaController::class, 'actualizarEstado'])->name('notas-venta.actualizarEstado');
    Route::get('/notas-venta/{id}/factura', [NotaVentaController::class, 'generarFactura'])->name('notas-venta.factura');
    Route::post('/notas-venta/{id}/pago', [NotaVentaController::class, 'registrarPago'])->name('notas-venta.registrarPago');

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/crear', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::get('/pedidos/show', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/pedidos/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
});

// Rutas para clientes
Route::middleware(['auth', 'role:cliente'])->group(function () {
    //Rutas para carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'addToCart'])->name('carrito.add');
    Route::post('/carrito/item', [CarritoController::class, 'removeItem'])->name('carrito.remove');
    Route::patch('/carrito/item', [CarritoController::class, 'updateQuantity'])->name('carrito.updateQ');
    Route::post('/pedido/generar', [CarritoController::class, 'generarPedido'])->name('pedido.generar');
    Route::get('/pedido/exito/{id}', [CarritoController::class, 'exitoPedido'])->name('pedido.exito');
    Route::get('/pedido/cancelado/{id}', [CarritoController::class, 'canceladoPedido'])->name('pedido.cancelado');
    Route::get('/cotizacion/pdf', [CarritoController::class, 'generarCotizacion'])->name('cotizacion.pdf');
});

// Rutas para reportes generales
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/reportes/inventario', fn() => Inertia::render('Reportes/ReporteInv'))->name('reportes.inventario.view');
});




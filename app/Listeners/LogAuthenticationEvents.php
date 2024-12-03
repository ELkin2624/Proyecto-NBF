<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\BitacoraController;
use Illuminate\Support\Facades\Auth;
use App\Models\Bitacora;

class LogAuthenticationEvents
{
    public function handle($event)
    {
        if ($event instanceof Login) {
            $accion = 'INICIO DE SESION';
            $detalles = 'El usuario ' . Auth::user()->name . ' ha iniciado sesión.';
        } elseif ($event instanceof Logout) {
            $accion = 'CIERRE DE SESION';
            $detalles = 'El usuario ' . Auth::user()->name . ' ha cerrado sesión.';
        } elseif ($event instanceof Registered) {
            $accion = 'REGISTRO DE USUARIO';
            $detalles = 'Se ha registrado un nuevo usuario: ' . $event->user->name;
        }else {
            return;
        }

        app(BitacoraController::class)->registrarAccion([
            'accion' => $accion,
            'detalles' => $detalles,
            'tabla_asociada' => 'usuarios',
        ]);
    }
}

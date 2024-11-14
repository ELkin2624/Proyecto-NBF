<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Bitacora;


class BitacoraController extends Controller
{
    public function registrarAccion($accion, $detalles = null, $tablaAsociada = null)
    {
        // Obtener la IP del usuario
        $ipUsuario = request()->ip();

        // Obtener la fecha y hora actuales
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');

        // Obtener el ID del usuario autenticado, si lo hay
        $idUsuario = Auth::check() ? Auth::id() : null;

        // Crear el registro en la bitácora
        Bitacora::create([
            'accion' => $accion,
            'ip_usuario' => $ipUsuario,
            'fecha' => $fecha,
            'hora' => $hora,
            'detalles' => $detalles,
            'tabla_asociada' => $tablaAsociada,
            'id_usuario' => $idUsuario,
        ]);
    }
}

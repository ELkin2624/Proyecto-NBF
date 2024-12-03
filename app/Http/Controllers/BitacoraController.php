<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {

        $bitacoras = Bitacora::with('usuario')->paginate(10);
        $users = User::all();

        // Retorna la vista 'Bitacora' junto con los registros de la bitácora y los usuarios
        return Inertia::render('Bitacora', [
            'bitacora' => $bitacoras,
            'usuarios' => $users, // Pasa los usuarios a la vista
        ]);
    }

    public function registrarAccion($datos)
    {
        Bitacora::create([
            'accion' => $datos['accion'],
            'ip_usuario' => request()->ip(),
            'fecha' => now()->format('Y-m-d'),
            'hora' => now()->format('H:i:s.u'),
            'detalles' => $datos['detalles'],
            'tabla_asociada' => $datos['tabla_asociada'],
            'id_usuario' => Auth::id(),
        ]);
    }
}

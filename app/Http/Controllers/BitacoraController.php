<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
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
=======
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
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        ]);
    }
}

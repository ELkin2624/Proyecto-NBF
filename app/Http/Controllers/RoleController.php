<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Bitacora;
use App\Http\Controllers\BitacoraController; 

class RoleController extends Controller
{
    public function index() {
        $users = User::all();
        return Inertia::render('Index', [
            'users' => $users,
            'auditLogs' => [], // Aquí puedes cargar los registros de la bitácora si lo deseas
        ]);
    }

    // Crear un nuevo usuario
    public function store(Request $request) {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rol' => 'required|string|in:admin,cliente',
        ]);

        // Crear el nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->password = bcrypt('password');
        $user->save();

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'CREAR USUARIO',
            'detalles' => 'Se ha creado un nuevo usuario: ' . $user->name . ' con correo: ' . $user->email,
            'tabla_asociada' => 'users',
        ]);

        return redirect()->route('users')->with('success', 'Usuario creado correctamente.');
    }

    // Actualizar la información de un usuario existente
    public function update(Request $request, $id_usuario) {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id_usuario,
            'rol' => 'required|string|in:admin,cliente',
        ]);

        // Buscar el usuario y actualizar sus datos
        $user = User::findOrFail($id_usuario);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->save();

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ACTUALIZAR USUARIO',
            'detalles' => 'Se ha actualizado la información del usuario: ' . $user->name,
            'tabla_asociada' => 'users',
        ]);

        return redirect()->route('users')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar un usuario
    public function destroy($id_usuario) {
        $user = User::findOrFail($id_usuario);
        $userName = $user->name; // Guardar el nombre del usuario antes de eliminar

        $user->delete();

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ELIMINAR USUARIO',
            'detalles' => 'Se ha eliminado al usuario: ' . $userName,
            'tabla_asociada' => 'users',
        ]);

        return redirect()->route('users')->with('success', 'Usuario eliminado correctamente.');
    }

    // Generar informe de auditoría (esto es un ejemplo simple)
    public function generateReport() {
        // Aquí podrías añadir lógica para generar un informe de auditoría
        // Por ejemplo, puedes consultar logs o actividades del sistema.

        // Retornar una vista o archivo de reporte
        return redirect()->route('users')->with('success', 'Informe de auditoría generado.');
    }
}

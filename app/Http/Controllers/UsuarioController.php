<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index() {
        $users = User::all();
        return Inertia::render('AdministrarUsuario/Index', [
            'users' => $users,
            'auditLogs' => [],
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

        return redirect()->route('users')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar un usuario
    public function destroy($id_usuario) {
        $user = User::findOrFail($id_usuario);
        $user->delete();

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

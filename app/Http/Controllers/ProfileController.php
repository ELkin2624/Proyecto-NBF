<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Método para mostrar la vista del perfil
    public function show()
    {
        // Puedes pasar al perfil el usuario autenticado
        return inertia('Profile/Show', [
            'user' => Auth::user(),
        ]);
    }

    // Método para actualizar el perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validación de los datos enviados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Actualización de los datos del usuario
        /*$user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);*/

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');
    }
}

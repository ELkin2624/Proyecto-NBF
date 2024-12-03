<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;

class PedidoController extends Controller
{
    public function index(){
        $pedidos = Pedido::with('cliente.usuario')->get();
        return inertia('Ventas/Pedido', [
            'pedidos' => $pedidos,
        ]);
    }

    public function create()
    {
        $productos = Producto::all(); // Esto es solo un ejemplo

        return inertia('Ventas/PedidoCreate', [
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_recepcion' => 'required|date',
            'estado' => 'required|string',
            'direccion' => 'required|string',
            'id_cliente' => 'required|integer',
        ]);

        $pedido = Pedido::create($validated);

        // Puedes crear los detalles del pedido aquí

        return redirect()->route('pedidos.index');
    }
}

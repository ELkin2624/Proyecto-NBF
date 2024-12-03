<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;

class ProductoVistaController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query()
            ->with(['marca', 'categoria'])
            ->when($request->filled('categoria'), function ($q) use ($request) {
                $q->whereIn('id_categoria', explode(',', $request->categoria));
            })
            ->when($request->filled('marca'), function ($q) use ($request) {
                $q->whereIn('id_marca', explode(',', $request->marca));
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function($query) use ($request) {
                    $query->where('nombre', 'ilike', "%{$request->search}%")
                          ->orWhere('descripcion', 'ilike', "%{$request->search}%");
                });
            })
            ->when($request->filled('orden') && $request->filled('direccion'), function ($q) use ($request) {
                if (in_array($request->orden, ['nombre', 'precioxMenor'])) {
                    $q->orderBy($request->orden, $request->direccion);
                }
            }, function ($q) {
                $q->orderBy('nombre', 'asc');
            })
            ->paginate(12);

        return Inertia::render('GestionarVistaCliente/ListaProducto', [
            'productos' => $query,
            'marcas' => Marca::select('id_marca', 'nombre')->get(),
            'categorias' => Categoria::select('id_categoria', 'nombre')->get(),
            'filters' => $request->only(['categoria', 'marca', 'search', 'orden', 'direccion']),
        ]);
    }

    public function show($codigo)
    {
        $producto = Producto::with(['marca', 'categoria'])
            ->where('codigo', $codigo)
            ->firstOrFail();

        return Inertia::render('GestionarVistaCliente/DetalleProducto', [
            'producto' => $producto,
        ]);
    }
}

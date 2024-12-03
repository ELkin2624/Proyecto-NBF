<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use Inertia\Inertia;
use App\Http\Controllers\BitacoraController;


class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query()->with(['marca', 'categoria', 'inventarioProducto']);

        $this->aplicarFiltros($query, $request);

        // Ordenar y paginar
        $sortableFields = ['nombre', 'precioxmayor', 'precioxmenor', 'codigo'];
        $sortBy = in_array($request->input('sort_by'), $sortableFields) ? $request->input('sort_by') : 'nombre';
        $sortOrder = $request->input('sort_order') === 'desc' ? 'desc' : 'asc';

        $productos = $query->orderBy($sortBy, $sortOrder)->paginate(10)->withQueryString();

        $marcas = Marca::all();
        $categorias = Categoria::all();

        return Inertia::render('GestionInventario/ProdIndex', [
            'productos' => $productos,
            'marcas' => $marcas,
            'categorias' => $categorias,
            'filters' => $this->getCleanFilters($request),
        ]);
    }

    protected function aplicarFiltros($query, $request)
    {
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('codigo', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('descripcion', 'ILIKE', "%{$searchTerm}%")
                  ->orWhereHas('marca', function ($q) use ($searchTerm) {
                      $q->where('nombre', 'ILIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('categoria', function ($q) use ($searchTerm) {
                      $q->where('nombre', 'ILIKE', "%{$searchTerm}%");
                  });
            });
        }

        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        if ($request->filled('precio_min')) {
            $query->where(function($q) use ($request) {
                $q->where('precioxmenor', '>=', $request->precio_min)
                  ->orWhere('precioxmayor', '>=', $request->precio_min);
            });
        }

        if ($request->filled('precio_max')) {
            $query->where(function($q) use ($request) {
                $q->where('precioxmenor', '<=', $request->precio_max)
                  ->orWhere('precioxmayor', '<=', $request->precio_max);
            });
        }

        if ($request->boolean('bajo_stock')) {
            $query->whereHas('inventarioProducto', function ($q) {
                $q->where('cantidad', '<=', config('app.stock_minimo', 50));
            });
        }
    }

    protected function getCleanFilters(Request $request): array
    {
        return array_filter([
            'search' => $request->input('search'),
            'categoria' => $request->input('categoria'),
            'precio_min' => $request->input('precio_min'),
            'precio_max' => $request->input('precio_max'),
            'bajo_stock' => $request->boolean('bajo_stock'),
            'sort_by' => $request->input('sort_by'),
            'sort_order' => $request->input('sort_order'),
        ], function ($value) {
            return $value !== null && $value !== '';
        });
    }

    public function create()
    {
        return Inertia::render('GestionInventario/CreateP', [
            'marcas' => Marca::all(),
            'categorias' => Categoria::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:producto,codigo',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precioxmayor' => 'required|numeric|min:0',
            'precioxmenor' => 'required|numeric|min:0',
            'id_marca' => 'required|exists:marca,id_marca',
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precioxmayor' => $request->precioxmayor,
            'precioxmenor' => $request->precioxmenor,
            'id_marca' => $request->id_marca,
            'id_categoria' => $request->id_categoria,
            'imagen_url' => $path,
        ]);

        // Registro en bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'INSERTAR PRODUCTO',
            'detalles' => 'Se ha insertado un nuevo producto: ' . $producto->nombre,
            'tabla_asociada' => 'producto',
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit($codigo)
    {
        $producto = Producto::where('codigo', $codigo)->first();
        $marcas = Marca::all();
        $categorias = Categoria::all();

        return Inertia::render('GestionInventario/ProductoEdit', [
            'producto' => $producto,
            'marcas' => $marcas,
            'categorias' => $categorias
        ]);
    }

    public function update(Request $request, $codigo)
    {
        $producto = Producto::where('codigo', $codigo)->firstOrFail();

        $request->validate([
            'codigo' => [
                'required',
                'string',
                Rule::unique('producto', 'codigo')->ignore($producto->codigo, 'codigo'),
            ],
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precioxmayor' => 'required|numeric',
            'precioxmenor' => 'required|numeric',
            'id_marca' => 'required|exists:marca,id_marca',
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen_url) {
                Storage::delete('public/' . $producto->imagen_url);
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen_url = $path;
        }

        $producto->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precioxmayor' => $request->precioxmayor,
            'precioxmenor' => $request->precioxmenor,
            'id_marca' => $request->id_marca,
            'id_categoria' => $request->id_categoria,
        ]);

        // Registro en bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ACTUALIZAR PRODUCTO',
            'detalles' => "Se actualizó el producto: {$producto->nombre}",
            'tabla_asociada' => 'producto',
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($codigo)
    {
        $producto = Producto::where('codigo', $codigo)->firstOrFail();

        if ($producto->imagen_url) {
            Storage::delete('public/' . $producto->imagen_url);
        }

        $nombreProducto = $producto->nombre;

        // Eliminar el producto (o aplicar soft delete)
        $producto->delete();

        // Registro en bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ELIMINAR PRODUCTO',
            'detalles' => 'Se ha eliminado el producto: ' . $nombreProducto,
            'tabla_asociada' => 'producto',
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}

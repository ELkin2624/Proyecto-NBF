<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade as Pdf;

use App\Models\User;
=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
use App\Models\NotaCompra;
use App\Models\DetalleNotaCompra;
use App\Models\Proveedor;
use App\Models\Producto;
<<<<<<< HEAD
use App\Models\HistorialNotaCompra;
use App\Models\Bitacora;
use App\Http\Controllers\BitacoraController;

=======
use App\Models\User;
use Inertia\Inertia;
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5

class NotaCompraController extends Controller
{
    public function index()
    {
        $notasCompra = NotaCompra::with('proveedor')->get(); // Obtener las notas de compra con los proveedores
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return Inertia::render('Compras/NotaCompraIndex', [
            'notasCompra' => $notasCompra,
            'proveedores' => $proveedores,
            'productos' => $productos,
        ]);
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
<<<<<<< HEAD
        return Inertia::render('Compras/NotaCompraCreate', [
=======
        return Inertia::render('Compras/NotaCompraForm', [
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
            'proveedores' => $proveedores,
            'productos' => $productos
        ]);
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
=======
        $validated = $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'fecha_orden' => 'required|date',
            'total' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.codigo_producto' => 'required|string',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio_unitario' => 'required|numeric',
            'productos.*.subtotal' => 'required|numeric',
        ]);

>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        $proveedor = Proveedor::findOrFail($request->id_proveedor);
        $tiempoEntregaMeses = $proveedor->tiempo_entrega;

        $fechaOrden = now();
        $fechaEntrega = $fechaOrden->copy()->addMonths($tiempoEntregaMeses);

<<<<<<< HEAD
        $notaCompra = new NotaCompra();
        $notaCompra->id_proveedor = $request->id_proveedor;
        $notaCompra->fecha_orden = $request->fecha_orden;
        $notaCompra->fecha_entrega = $fechaEntrega;
        $notaCompra->estado = 'En espera';
        $notaCompra->id_admin = auth()->user()->id;

         // Calcular el total sumando los subtotales de los detalles
        $total = collect($request->detalles)->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['precio_unitario'];
        });
        $notaCompra->total = $total;
        $notaCompra->save();

        // Agregar detalles de productos
        foreach ($request->detalles as $detalle) {
            DetalleNotaCompra::create([
                'id_nota_compra' => $notaCompra->id_nota_compra,
                'codigo_producto' => $detalle['codigo_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
                'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
            ]);
        }

        // Registro en bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'CREAR NOTA DE COMPRA',
            'detalles' => "Se ha creado una nueva nota de compra con ID: {$notaCompra->id}",
            'tabla_asociada' => 'nota_compra',
            'usuario_id' => auth()->user()->id,
        ]);

        return redirect()->route('notas-compra.index');
    }

    public function edit($id)
    {
        $notaCompra = NotaCompra::with('detalles')->findOrFail($id);
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return inertia('Compras/NotaCompraEdit', [
            'notaCompra' => $notaCompra,
            'proveedores' => $proveedores,
            'productos' => $productos,
        ]);
    }

    public function update(Request $request, $id)
    {
        $notaCompra = NotaCompra::findOrFail($id);

        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'fecha_orden' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_orden',
            'estado' => 'required|string|in:En espera,En proceso,Completada,Cancelada',
            'detalles' => 'required|array',
            'detalles.*.codigo_producto' => 'required|exists:producto,codigo',
            'detalles.*.cantidad' => 'required|numeric|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detallesAdicionales' => 'nullable|string|max:255',
        ]);

        $total = collect($validatedData['detalles'])->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['precio_unitario'];
        });

        // Registrar historial
        HistorialNotaCompra::create([
            'id_nota_compra' => $notaCompra->id_nota_compra,
            'estado_anterior' => $notaCompra->estado,
            'estado_nuevo' => $validatedData['estado'],
            'fecha' => now(),
            'detalles' => $validatedData['detallesAdicionales'] ?? '',
        ]);

        // Actualizar NotaCompra
        $notaCompra->update([
            'id_proveedor' => $validatedData['id_proveedor'],
            'fecha_orden' => $validatedData['fecha_orden'],
            'fecha_entrega' => $validatedData['fecha_entrega'],
            'estado' => $validatedData['estado'],
            'total' => $total,
        ]);

        // Eliminar los detalles antiguos
        DetalleNotaCompra::where('id_nota_compra', $notaCompra->id_nota_compra)->delete();

        // Actualizar detalles
        foreach ($validatedData['detalles'] as $detalle) {
            DetalleNotaCompra::create([
                'id_nota_compra' => $notaCompra->id_nota_compra,
                'codigo_producto' => $detalle['codigo_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
                'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
            ]);
        }

        // Registrar acción en bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ACTUALIZAR ESTADO NOTA DE COMPRA',
            'detalles' => "Se actualizó la nota de compra con ID: {$notaCompra->id_nota_compra}",
            'tabla_asociada' => 'nota_compra',
            'usuario_id' => auth()->user()->id,
        ]);

        return redirect()->route('notas-compra.index')->with('success', 'Nota de compra actualizada con éxito.');
    }

    public function registrarRecepcion(Request $request, $id)
    {
        $notaCompra = NotaCompra::findOrFail($id);

        // Validación de los datos enviados
        $validatedData = $request->validate([
            'detalles.*.cantidad_recibida' => 'required|integer|min:1',
            'detalles.*.detalles_danados' => 'nullable|string|max:255',
        ]);

        // Actualizar el inventario y registrar la recepción
        foreach ($validatedData['detalles'] as $detalle) {
            $producto = Producto::where('codigo', $detalle['codigo_producto'])->first();
            $producto->cantidad_en_inventario += $detalle['cantidad_recibida']; // Aumentamos la cantidad en inventario

            // Registrar el cambio en el inventario (si fuera necesario)
            $producto->save();

            // Si hubo productos dañados, registramos el detalle
            if ($detalle['detalles_danados']) {
                // Puede almacenarse en una tabla de detalles de productos dañados si se requiere
            }
        }

        // Actualizar el estado de la nota de compra
        $notaCompra->update(['estado' => 'Completada']);

        // Registrar en el historial
        HistorialNotaCompra::create([
            'id_nota_compra' => $notaCompra->id_nota_compra,
            'estado_anterior' => $notaCompra->estado,
            'estado_nuevo' => 'Completada',
            'fecha' => now(),
            'detalles' => 'Recepción de productos registrada.',
        ]);

        return redirect()->route('notas_compra.index')->with('success', 'Recepción registrada con éxito.');
    }

    public function generarReportes(Request $request)
    {
        //$notasCompra = NotaCompra::with('proveedor', 'detalles')->get();
        //$pdf = Pdf::loadView('reportes.notas-compra', compact('notasCompra'));
        //return $pdf->stream('reporte_notas_compra.pdf');

        $query = NotaCompra::query();

        // Filtrar por fecha
        if ($request->fecha_inicio) {
            $query->where('fecha_orden', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->where('fecha_orden', '<=', $request->fecha_fin);
        }

        // Filtrar por proveedor
        if ($request->proveedor) {
            $query->where('id_proveedor', $request->proveedor);
        }

        // Filtrar por estado
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        $reportes = $query->with('proveedor')->get()->map(function($notaCompra) {
            return [
                'id_nota_compra' => $notaCompra->id_nota_compra,
                'fecha_orden' => $notaCompra->fecha_orden,
                'proveedor_nombre' => $notaCompra->proveedor->nombre,
                'estado' => $notaCompra->estado,
                'total' => $notaCompra->total,
            ];
        });

        return Inertia::render('Reportes/ReporteNotaCompra', [
            'reportes' => $reportes,
            'proveedores' => Proveedor::all(),
        ]);
    }

    public function descargarReportePDF($id)
    {
        $notaCompra = NotaCompra::with('detalles', 'proveedor')->findOrFail($id);
        //$pdf = PDF::loadView('reportes.nota_compra_pdf', compact('notaCompra'));
        //return $pdf->download("nota_compra_{$id}.pdf");
    }

    public function historial($id)
    {
        // Verificar si la nota de compra existe
        $notaCompra = NotaCompra::with('proveedor')->findOrFail($id);

        // Obtener el historial asociado a la nota de compra
        $historial = HistorialNotaCompra::where('id_nota_compra', $id)
        ->orderBy('fecha', 'desc')
        ->get();

        app(BitacoraController::class)->registrarAccion([
            'accion' => "Vizualiza el historial de la nota de compra: {$notaCompra->id_nota_compra}",
            'detalles' => "Se visualizo el historial de la nota de compra con ID: {$notaCompra->id_nota_compra}",
            'tabla_asociada' => 'nota_compra',
            'usuario_id' => auth()->user()->id,
        ]);

        return Inertia::render('Compras/Historial', [
            'notaCompra' => $notaCompra,
            'historial' => $historial,
        ]);
    }

    public function recibirProductos(Request $request, $id)
    {
        // Validar los datos enviados desde el frontend
        $request->validate([
            'productos.*.codigo_producto' => 'required|exists:producto,codigo',
            'productos.*.cantidad_recibida' => 'required|integer|min:0',
        ]);

        // Obtener la nota de compra
        $notaCompra = NotaCompra::findOrFail($id);

        // Verificar que la nota esté en estado "En proceso"
        if ($notaCompra->estado !== 'En proceso') {
            return back()->withErrors(['error' => 'Solo se pueden recibir productos de notas en proceso.']);
        }

        // Actualizar inventario y registrar recepción
        foreach ($request->productos as $producto) {
            // Buscar el producto en el detalle de la nota
            $detalle = DetalleNotaCompra::where('id_nota_compra', $id)
                ->where('codigo_producto', $producto['codigo_producto'])
                ->first();

            if ($detalle) {
                // Actualizar inventario (lógica personalizada)
                // Aquí puedes implementar lógica para actualizar tu tabla de inventario
            }
        }

        // Actualizar estado de la nota de compra
        $notaCompra->estado = 'Completada';
        $notaCompra->save();

        // Registrar en el historial
        HistorialNotaCompra::create([
            'id_nota_compra' => $notaCompra->id_nota_compra,
            'estado_anterior' => 'En proceso',
            'estado_nuevo' => 'Completada',
            'detalles' => 'Productos recibidos correctamente.',
        ]);

        return redirect()->route('notas-compra.index')->with('success', 'Productos recibidos y nota completada.');
    }
}

=======
        $notaCompra = NotaCompra::create([
            'id_proveedor' => $request->id_proveedor,
            'fecha_orden' => $request->fecha_orden,
            'fecha_entrega' => $fechaEntrega,
            'estado' => 'En espera',
            'id_admin' => auth()->user()->id,
            'total' => $request->total,
        ]);

        foreach ($request->productos as $producto) {
            DetalleNotaCompra::create([
                'id_nota_compra' => $notaCompra->id_nota_compra,
                'codigo_producto' => $producto['codigo_producto'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['subtotal'],
            ]);
        }

        return Inertia::render('Compras/NotaCompraIndex', [
            'success' => true,
            'message' => 'Nota de compra creada correctamente.'
        ]);
    }

    public function actualizarEstado(Request $request, $id)
    {
        $notaCompra = NotaCompra::findOrFail($id);
        $notaCompra->estado = $request->estado;
        $notaCompra->save();

        return redirect()->route('nota-compra.index');
    }
}
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5

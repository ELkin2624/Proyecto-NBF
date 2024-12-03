<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\NotaVenta;
use App\Models\DetalleNotaVenta;
use App\Models\InventarioProducto;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class NotaVentaController extends Controller
{
    public function index(Request $request)
    {
        $notas = NotaVenta::with(['metodoPago', 'admin', 'detalles'])
            //->filter($request->all()) // Implementar un scope para filtros
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return inertia('Ventas/NVIndex', compact('notas'));
    }

    public function create()
    {
        $metodos = MetodoPago::all();
        return inertia('Ventas/NVCreate', [
            'metodos' => $metodos,
        ]);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'estado' => 'required|string|in:pendiente,pagada,cancelada',
            'motivo' => 'nullable|string|max:255',
        ]);

        $nota = NotaVenta::findOrFail($id);
        $nota->update([
            'estado' => $validated['estado'],
            'motivo' => $validated['motivo'] ?? null,
        ]);

        return redirect()->route('notas-venta.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'monto_total' => 'required|numeric',
            'tipo' => 'required|string',
            'id_referencia' => 'nullable|integer',
            'id_admin' => 'required|integer|exists:administrador,id_admin',
            'id_metodo' => 'required|integer|exists:metodo_pago,id_metodo',
            'detalles' => 'required|array',
            'detalles.*.codigo_producto' => 'required|string|exists:producto,codigo',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $notaVenta = NotaVenta::create([
                'fecha' => $validated['fecha'],
                'monto_total' => $validated['monto_total'],
                'tipo' => 'Manual',
                'id_referencia' => null,
                'id_admin' => $validated['id_admin'],
                'id_metodo' => $validated['id_metodo'],
                'estado' => 'Pendiente',
            ]);

            foreach ($validated['detalles'] as $detalle) {
                DetalleNotaVenta::create([
                    'id_venta' => $notaVenta->id_venta,
                    'codigo_producto' => $detalle['codigo_producto'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }

            DB::commit();
            return redirect()->route('notas-venta.index')->with('success', 'Nota de venta creada manualmente con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear nota de venta manual: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al crear la nota de venta manual.');
        }
    }

    public function reportes(Request $request)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $query = NotaVenta::query();

        if ($validated['fecha_inicio'] ?? false) {
            $query->where('fecha', '>=', $validated['fecha_inicio']);
        }

        if ($validated['fecha_fin'] ?? false) {
            $query->where('fecha', '<=', $validated['fecha_fin']);
        }

        $ventas = $query->with('detalles.producto', 'metodoPago')->get();

        $reporte = [
            'ventas_totales' => $ventas->sum('monto_total'),
            'productos_vendidos' => $ventas->flatMap->detalles->count(),
            'metodos_pago' => $ventas->groupBy('id_metodo')->map->count(),
        ];

        return inertia('Reportes/Index', [
            'ventas' => $ventas,
            'reporte' => $reporte,
        ]);
    }

    public function generarFactura($id)
    {
        $nota = NotaVenta::with(['detalles.producto', 'metodoPago', 'administrador'])->findOrFail($id);

        $pdf = Pdf::loadView('facturas.factura', ['nota' => $nota]);

        // Opcional: Guardar PDF en el servidor
        $path = storage_path("app/public/facturas/factura-{$id}.pdf");
        $pdf->save($path);

        return $pdf->download("Factura-{$id}.pdf");
    }
}

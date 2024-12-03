<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\NotaVenta;
use App\Models\DetalleNotaVenta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as Dompdf;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cliente = Cliente::where('id_usuario', $user->id_usuario)->first();
        if (!$cliente) {
            return redirect()->back()->withErrors('No se encontró un cliente asociado al usuario.');
        }

        $carrito = Carrito::with('items.producto')
            ->where('id_cliente', $cliente->id_cliente)
            ->first();

        return inertia('GestionarVistaCliente/Carrito', [
            'carrito' => $carrito,
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'codigo_producto' => 'required|exists:producto,codigo',
            'cantidad' => 'required|integer|min:1',
        ]);

        $usuario = Auth::user();
        $cliente = Cliente::where('id_usuario', $usuario->id_usuario)->first();
        if (!$cliente) {
            return redirect()->back()->withErrors('No se encontró un cliente asociado al usuario.');
        }

        $producto = Producto::findOrFail($request->codigo_producto);

        $carrito = Carrito::firstOrCreate(
            ['id_cliente' => $cliente->id_cliente],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Comprobar si el producto ya está en el carrito
        $item = CarritoItem::where('id_carrito', $carrito->id_carrito)
            ->where('codigo_producto', $producto->codigo)
            ->first();

        if ($item) {
            // Actualizar la cantidad del producto en el carrito
            $item->cantidad += $request->cantidad;
            $item->updated_at = now();
            $item->save();
        } else {
            // Agregar un nuevo producto al carrito
            CarritoItem::create([
                'id_carrito' => $carrito->id_carrito,
                'codigo_producto' => $producto->codigo,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $producto->precioxmenor,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('vistap.index')->with('success', 'Producto añadido al carrito exitosamente');
    }

    public function removeItem(Request $request)
    {
        $itemId = $request->input('id_carrito_item');
        $user = Auth::user();
        $cliente = Cliente::where('id_usuario', $user->id_usuario)->first();
        if (!$cliente) {
            return redirect()->back()->withErrors('No se encontró un cliente asociado al usuario.');
        }

        $item = CarritoItem::whereHas('carrito', function ($query) use ($cliente) {
            $query->where('id_cliente', $cliente->id_cliente);
        })->find($itemId);

        if ($item) {
            $item->delete();
            return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->route('carrito.index')->withErrors('Error: El producto no fue eliminado del carrito.');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'id_carrito_item' => 'required|exists:carrito_item,id_carrito_item',
            'cantidad' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cliente = Cliente::where('id_usuario', $user->id_usuario)->first();
        if (!$cliente) {
            return redirect()->back()->withErrors('No se encontró un cliente asociado al usuario.');
        }

        $item = CarritoItem::whereHas('carrito', function ($query) use ($cliente) {
            $query->where('id_cliente', $cliente->id_cliente);
        })->find($request->id_carrito_item);

        if ($item) {
            $item->cantidad = $request->cantidad;
            $item->save();

            return response()->json(['message' => 'Cantidad actualizada correctamente.'], 200);
        }

        return response()->json(['message' => 'Producto no encontrado o no autorizado.'], 404);
    }

    public function generarPedido(Request $request)
    {
        DB::beginTransaction(); // Usar transacciones para consistencia de datos
        try {
            $user = Auth::user();
            $cliente = Cliente::where('id_usuario', $user->id_usuario)->firstOrFail();

            $carrito = Carrito::with('items.producto')->where('id_cliente', $cliente->id_cliente)->firstOrFail();

            /*foreach ($carrito->items as $item) {
                if ($item->cantidad > $item->producto->inventarioProducto->cantidad) {
                    throw new \Exception("Stock insuficiente para el producto: " . $item->producto->nombre);
                }
            }*/

            $pedido = Pedido::create([
                'fecha_recepcion' => now(),
                'estado' => 'Pendiente',
                'direccion' => $cliente->direccion,
                'id_cliente' => $cliente->id_cliente,
            ]);

            $totalVenta = 0;

            // Crear los detalles del pedido
            foreach ($carrito->items as $item) {
                /*if (empty($item->producto->nombre) || $item->precio_unitario <= 0) {
                    throw new \Exception('Producto inválido en el carrito.');
                }*/

                $subtotal = $item->cantidad * $item->precio_unitario;
                $totalVenta += $subtotal;

                DetallePedido::create([
                    'precio_unitario' => $item->precio_unitario,
                    'cantidad' => $item->cantidad,
                    'subtotal' => $subtotal,
                    'id_pedido' => $pedido->id_pedido,
                    'codigo_producto' => $item->codigo_producto,
                ]);

               /* $item->producto->inventarioProducto->cantidad -= $item->cantidad;
                $item->producto->save();*/
            }

            // Crear la nota de venta asociada al pedido
            $notaVenta = NotaVenta::create([
                'fecha' => now(),
                'monto_total' => $totalVenta,
                'tipo' => 'Automática',
                'id_referencia' => $pedido->id_pedido,
                'id_admin' => null, // No hay administrador porque es automática
                'id_metodo' => 2,
                'estado' => 'Pendiente',
            ]);

            // Crear los detalles de la nota de venta
            foreach ($carrito->items as $item) {
                DetalleNotaVenta::create([
                    'id_venta' => $notaVenta->id_venta,
                    'codigo_producto' => $item->codigo_producto,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->cantidad * $item->precio_unitario,
                ]);
            }

            $lineItems = $carrito->items->map(function ($item) {
                if (empty($item->producto->nombre) || $item->precio_unitario <= 0) {
                    throw new \Exception('Producto inválido en el carrito. Verifica los datos del producto.');
                }
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->producto->nombre, // Acceso seguro a la relación producto
                        ],
                        'unit_amount' => intval($item->precio_unitario * 100),
                    ],
                    'quantity' => $item->cantidad, // Acceso seguro a la propiedad cantidad
                ];
            })->toArray();

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('pedido.exito', ['id' => $pedido->id_pedido]),
                'cancel_url' => route('pedido.cancelado', ['id' => $pedido->id_pedido]),
            ]);

            $carrito->items()->delete();
            $carrito->delete();

            DB::commit();

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al generar pedido: ' . $e->getMessage());
            return response()->json(['message' => 'Error creando la sesión de Stripe: ' . $e->getMessage()], 500);
        }
    }

    public function exitoPedido($id)
    {
        DB::beginTransaction();
        try{
            $pedido = Pedido::findOrFail($id);
            $pedido->estado = 'Pagado';
            $pedido->fecha_recepcion = now();
            $pedido->save();

            DB::commit();
            return view('pedido.exito', compact('pedido'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en pago exitoso: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Hubo un problema procesando tu pago.');
        }
    }

    public function canceladoPedido($id)
    {
        DB::beginTransaction();
        try {
            $pedido = Pedido::findOrFail($id);
            $pedido->estado = 'Cancelado';
            $pedido->save();

            // Restaurar stock de productos
            foreach ($pedido->detalles as $detalle) {
                $producto = Producto::find($detalle->codigo_producto);
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }

            DB::commit();
            return view('pedido.cancelado', compact('pedido'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en cancelaci√≥n de pedido: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Hubo un problema cancelando tu pedido.');
        }
    }

    public function generarCotizacion(Request $request)
    {
        $user = Auth::user();
        $cliente = Cliente::where('id_usuario', $user->id_usuario)->first();
        if (!$cliente) {
            return redirect()->back()->withErrors('No se encontró un cliente asociado al usuario.');
        }
        $carrito = Carrito::with('items.producto')->where('id_cliente', $cliente->id_cliente)->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return response()->json(['message' => 'El carrito está vacío.'], 400);
        }

        // Crear cotización
        $cotizacion = Cotizacion::create([
            'fecha_recepcion' => now(),
            'estado' => 'Generada',
            'direccion' => $user->direccion,
            'id_cliente' => $cliente->id_cliente,
        ]);

        // Crear los detalles de la cotización
        foreach ($carrito->items as $item) {
            DetalleCotizacion::create([
                'precio_unitario' => $item->precio_unitario,
                'cantidad' => $item->cantidad,
                'subtotal' => $item->cantidad * $item->precio_unitario,
                'id_cotizacion' => $cotizacion->id_cotizacion,
                'codigo_producto' => $item->codigo_producto,
            ]);
        }

        // Generar el PDF
        $data = [
            'cotizacion' => $cotizacion,
            'items' => $carrito->items,
            'cliente' => $cliente,
            'titulo' => 'Cotizaciones'
        ];

        $pdf = Dompdf::loadView('cotizaciones.pdf', $data);

        // Opción de descargar o enviar por correo
        if ($request->has('descargar')) {
            return $pdf->download('cotizacion.pdf');
        } elseif ($request->has('enviar')) {
            //Mail::to($user->email)->send(new CotizacionEmail($pdf->output()));
            return response()->json(['message' => 'Cotización enviada por correo.'], 200);
        }

        return $pdf->stream('cotizacion.pdf');
    }
}

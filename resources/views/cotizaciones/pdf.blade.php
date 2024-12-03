<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-cliente, .detalle-cotizacion {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cotización</h1>
        <p>Fecha: {{ $cotizacion->fecha_recepcion->format('d/m/Y') }}</p>
    </header>

    <section class="info-cliente">
        <h3>Datos del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $cliente->usuario->name }}</p>
        <p><strong>Dirección:</strong> {{ $cotizacion->direccion }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $cliente->usuario->email }}</p>
    </section>

    <section class="detalle-cotizacion">
        <h3>Detalle de Productos</h3>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->producto->codigo }}</td>
                        <td>{{ $item->producto->nombre }}</td>
                        <td>{{ number_format($item->precio_unitario, 2) }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ number_format($item->cantidad * $item->precio_unitario, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total">Total</td>
                    <td>{{ number_format($items->sum(fn($item) => $item->cantidad * $item->precio_unitario), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </section>

    <footer>
        <p>Gracias por su preferencia.</p>
    </footer>
</body>
</html>

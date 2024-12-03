<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Factura #{{ $nota->id }}</h1>
        <p>Fecha: {{ $nota->fecha }}</p>
    </div>

    <h3>Información del Cliente</h3>
    <p>Nombre: {{ $nota->cliente_nombre }}</p>
    <p>Correo: {{ $nota->cliente_correo }}</p>
    <p>Teléfono: {{ $nota->cliente_telefono }}</p>

    <h3>Detalles de los Productos</h3>
    <table class="details">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nota->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: ${{ number_format($nota->monto_total, 2) }}</h3>

    <div class="footer">
        <p>Gracias por su compra</p>
    </div>
</body>
</html>

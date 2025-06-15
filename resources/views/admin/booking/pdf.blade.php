<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reserva</title>
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Listado de Reserva</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Fecha</th>
                <th>Costo Entrada</th>
                <th>Cantidad</th>
                <th>Costo Total</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Evento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->codigo }}</td>
                <td>{{ $booking->fecha }}</td>
                <td>{{ $booking->costo_entrada }}</td>
                <td>{{ $booking->cantidad }}</td>
                <td>{{ $booking->costo_total }}</td>
                <td>{{ $booking->estado }}</td>
                <td>{{ $booking->usuario->name }}</td>
                <td>{{ $booking->evento->nombre }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

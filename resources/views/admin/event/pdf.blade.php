<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Eventos</title>
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
    <h1>Listado de Eventos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Capacidad</th>
                <th>Precio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Ubicacion</th>
                <th>Estado</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->nombre }}</td>
                <td>{{ $event->descripcion }}</td>
                <td>{{ $event->capacidad }}</td>
                <td>{{ $event->precio_entrada }}</td>
                <td>{{ $event->fecha }}</td>
                <td>{{ $event->hora }}</td>
                <td>{{ $event->ubicacion }}</td>
                <td>{{ $event->estado }}</td>
                <td>{{ $event->imagen }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

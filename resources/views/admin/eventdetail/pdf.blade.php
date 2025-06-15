<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Evento - Servicios</title>
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
    <h1>Listado de Evento - Servicios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Evento</th>
                <th>Servicio</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventdetails as $eventdetail)
            <tr>
                <td>{{ $eventdetail->id }}</td>
                <td>{{ $eventdetail->evento->nombre }}</td>
                <td>{{ $eventdetail->servicio->nombre }}</td>
                <td>{{ $eventdetail->costo_servicio }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

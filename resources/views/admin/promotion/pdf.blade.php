<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Promocion</title>
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
    <h1>Listado de Promocion</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Descuento</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Evento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->id }}</td>
                <td>{{ $promotion->descripcion }}</td>
                <td>{{ $promotion->descuento }}</td>
                <td>{{ $promotion->fecha_inicio }}</td>
                <td>{{ $promotion->fecha_fin }}</td>
                <td>{{ $promotion->evento->nombre }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

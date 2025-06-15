<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Patrocinadores</title>
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
    <h1>Listado de Patrocinadores</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sponsors as $sponsor)
            <tr>
                <td>{{ $sponsor->id }}</td>
                <td>{{ $sponsor->nombre }}</td>
                <td>{{ $sponsor->descripcion }}</td>
                <td>{{ $sponsor->email }}</td>
                <td>{{ $sponsor->telefono }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

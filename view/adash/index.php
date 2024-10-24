<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dinámico</title>
    <!-- Cargar el archivo CSS de GridStack -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gridstack@10.3.1/dist/gridstack.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .grid-stack-item-content {
            background-color: #F0F0F0;
            border: 1px solid #CCC;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;

        }

        .grid-stack-item-content:hover {
            background-color: #e2e2e2;
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: #fff;
            padding: 5px;
            border-radius: 3px;
        }

        .group-header input {
            background-color: transparent;
            color: #fff;
            border: none;
        }

        .card {
            background-color: #f8d7da;
            border-radius: 5px;
            padding: 10px;
            margin: 5px 0;
            color: #721c24;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Dashboard Dinámico</h1>
    <button id="addGroup" class="btn">Agregar Grupo</button>
    <div class="grid-stack"></div>

    <!-- Cargar GridStack.js versión 10.3.1 -->
    <script src="https://cdn.jsdelivr.net/npm/gridstack@10.3.1/dist/gridstack-all.js"></script>
    <!-- Cargar tu archivo JavaScript -->
    <script src="dashboard.js"></script>
</body>

</html>
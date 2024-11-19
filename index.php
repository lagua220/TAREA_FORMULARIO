<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro de Empleados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffff;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .mensaje {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Formulario de Registro de Empleados</h2>
    <form action="" method="POST">
        <label for="id_empleado">ID del Empleado:</label>
        <input type="number" id="id_empleado" name="id_empleado" required>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="salario">Salario:</label>
        <input type="number" id="salario" name="salario" required min="400">

        <button type="submit">Registrar Empleado</button>
    </form>

    <div class="mensaje">
        <?php
        // Mostrar errores para depuración
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Datos de conexión
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "registro_empleados";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("<p style='color: red;'>Error de conexión: " . $conn->connect_error . "</p>");
        }

        // Verificar si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Escapar datos del formulario
            $id_empleado = intval($_POST['id_empleado']);
            $nombre = $conn->real_escape_string($_POST['nombre']);
            $salario = floatval($_POST['salario']); // Convertir a número para validar

            // Validar salario
            if ($salario < 400) {
                echo "<p style='color: red;'>El salario no puede ser menor a 400.</p>";
            } else {
                // Consulta SQL
                $sql = "INSERT INTO datos_empleado (id_empleado, nombre, salario) VALUES ($id_empleado, '$nombre', $salario);";
                if ($conn->query($sql) === TRUE) {
                    echo "<p style='color: green;'>Empleado registrado exitosamente.</p>";
                } else {
                    echo "<p style='color: red;'>Error al registrar el empleado: " . $conn->error . "</p>";
                }
            }
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>

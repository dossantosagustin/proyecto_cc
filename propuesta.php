<?php

include "conexion.php";

// Obtener la fecha seleccionada desde el calendario
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';


// Buscar la disponibilidad correspondiente a esa fecha
$disponibilidad = null;

if ($fecha != '') {

    $sql = "SELECT *
            FROM disponibilidad
            WHERE fecha = ? AND estado = 'DISPONIBLE'
            LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $fecha);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $disponibilidad = $resultado->fetch_assoc();
    }

}


// Si no existe una disponibilidad válida
if (!$disponibilidad) {

    echo "<h2>La fecha seleccionada no está disponible.</h2>";
    echo '<a href="calendario.php">Volver al calendario</a>';
    exit;

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Enviar propuesta</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .contenedor {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .fecha {
            background-color: #d4edda;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            margin-top: 25px;
            padding: 12px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

    </style>

</head>


<body>

<div class="contenedor">

    <h1>Enviar propuesta</h1>


    <div class="fecha">

        <strong>Fecha seleccionada:</strong>

        <?php echo htmlspecialchars($disponibilidad['fecha']); ?>

        <br>

        <strong>Horario:</strong>

        <?php echo htmlspecialchars($disponibilidad['hora_inicio']); ?>

        -

        <?php echo htmlspecialchars($disponibilidad['hora_fin']); ?>

    </div>


    <form action="guardar_propuesta.php" method="POST">

        <!-- ID de la disponibilidad -->

        <input
            type="hidden"
            name="id_disponibilidad"
            value="<?php echo $disponibilidad['id_disponibilidad']; ?>"
        >


        <label for="nombre_banda">
            Nombre de la banda
        </label>

        <input
            type="text"
            id="nombre_banda"
            name="nombre_banda"
            required
        >


        <label for="genero_estilo">
            Género / estilo musical
        </label>

        <input
            type="text"
            id="genero_estilo"
            name="genero_estilo"
            required
        >


        <label for="email">
            Email de contacto
        </label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >


        <label for="telefono">
            Teléfono / WhatsApp
        </label>

        <input
            type="text"
            id="telefono"
            name="telefono"
            required
        >


        <label for="descripcion">
            Descripción de la propuesta
        </label>

        <textarea
            id="descripcion"
            name="descripcion"
            required
        ></textarea>


        <label for="rider">
            Rider técnico (opcional)
        </label>

        <input
            type="text"
            id="rider"
            name="rider"
        >


        <button type="submit">
            Enviar propuesta
        </button>

    </form>

</div>

</body>

</html>
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Enviar propuesta</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px 20px;
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

        h2 {
            margin-top: 30px;
            margin-bottom: 15px;
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
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            min-height: 120px;
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
            font-size: 16px;
        }

        button:hover {
            background-color: #555;
        }

        .volver {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #333;
        }

    </style>

</head>


<body>

<div class="contenedor">

    <a class="volver" href="calendario.php">
        ← Volver al calendario
    </a>

    <h1>Enviar propuesta</h1>


    <!-- FECHA Y HORARIO SELECCIONADOS -->

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


        <!-- ID DE LA DISPONIBILIDAD -->

        <input
            type="hidden"
            name="id_disponibilidad"
            value="<?php echo $disponibilidad['id_disponibilidad']; ?>"
        >


        <!-- DATOS DEL PROYECTO -->

        <h2>Datos del proyecto</h2>


        <label for="nombre_banda">
            Nombre de la banda o proyecto:
        </label>

        <input
            type="text"
            id="nombre_banda"
            name="nombre_banda"
            maxlength="150"
            required
        >


        <label for="genero_estilo">
            Género o estilo musical:
        </label>

        <input
            type="text"
            id="genero_estilo"
            name="genero_estilo"
            maxlength="100"
            required
        >


        <label for="descripcion_proyecto">
            Descripción del proyecto:
        </label>

        <textarea
            id="descripcion_proyecto"
            name="descripcion_proyecto"
            rows="5"
            required
        ></textarea>


        <label for="redes_sociales">
            Redes sociales:
        </label>

        <input
            type="text"
            id="redes_sociales"
            name="redes_sociales"
            maxlength="255"
        >


        <label for="link_musica">
            Link para escuchar música:
        </label>

        <input
            type="url"
            id="link_musica"
            name="link_musica"
            maxlength="500"
            placeholder="Spotify, YouTube, Bandcamp, etc."
            required
        >


        <label for="link_presentacion">
            Link a una presentación en vivo:
        </label>

        <input
            type="url"
            id="link_presentacion"
            name="link_presentacion"
            maxlength="500"
        >


        <!-- DATOS DE CONTACTO -->

        <h2>Datos de contacto</h2>


        <label for="nombre_contacto">
            Nombre y apellido:
        </label>

        <input
            type="text"
            id="nombre_contacto"
            name="nombre_contacto"
            maxlength="150"
            required
        >


        <label for="email">
            Email:
        </label>

        <input
            type="email"
            id="email"
            name="email"
            maxlength="150"
            required
        >


        <label for="telefono_whatsapp">
            Teléfono / WhatsApp:
        </label>

        <input
            type="tel"
            id="telefono_whatsapp"
            name="telefono_whatsapp"
            maxlength="50"
            required
        >


        <!-- PROPUESTA -->

        <h2>Propuesta</h2>


        <label for="descripcion_propuesta">
            ¿Qué propuesta les gustaría realizar en el Centro Cultural?
        </label>

        <textarea
            id="descripcion_propuesta"
            name="descripcion_propuesta"
            rows="6"
            required
        ></textarea>


        <label for="rider_tecnico">
            Rider técnico:
        </label>

        <textarea
            id="rider_tecnico"
            name="rider_tecnico"
            rows="4"
        ></textarea>


        <!-- BOTÓN -->

        <button type="submit">
            Enviar propuesta
        </button>


    </form>

</div>

</body>

</html>
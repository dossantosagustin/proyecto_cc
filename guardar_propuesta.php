<?php

include "conexion.php";


// ======================================================
// VERIFICAR QUE EL FORMULARIO HAYA SIDO ENVIADO
// ======================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo "<h2>Acceso no válido.</h2>";
    echo '<a href="calendario.php">Volver al calendario</a>';
    exit;

}


// ======================================================
// RECIBIR LOS DATOS DEL FORMULARIO
// ======================================================

$id_disponibilidad = isset($_POST['id_disponibilidad'])
    ? intval($_POST['id_disponibilidad'])
    : 0;

$nombre_banda = trim($_POST['nombre_banda'] ?? '');

$genero_estilo = trim($_POST['genero_estilo'] ?? '');

$descripcion_proyecto = trim($_POST['descripcion_proyecto'] ?? '');

$redes_sociales = trim($_POST['redes_sociales'] ?? '');

$link_musica = trim($_POST['link_musica'] ?? '');

$link_presentacion = trim($_POST['link_presentacion'] ?? '');

$nombre_contacto = trim($_POST['nombre_contacto'] ?? '');

$email = trim($_POST['email'] ?? '');

$telefono_whatsapp = trim($_POST['telefono_whatsapp'] ?? '');

$descripcion_propuesta = trim($_POST['descripcion_propuesta'] ?? '');

$rider_tecnico = trim($_POST['rider_tecnico'] ?? '');


// ======================================================
// VERIFICAR CAMPOS OBLIGATORIOS
// ======================================================

if (
    $id_disponibilidad <= 0 ||
    $nombre_banda === '' ||
    $genero_estilo === '' ||
    $descripcion_proyecto === '' ||
    $link_musica === '' ||
    $nombre_contacto === '' ||
    $email === '' ||
    $telefono_whatsapp === '' ||
    $descripcion_propuesta === ''
) {

    echo "<h2>Faltan completar algunos campos obligatorios.</h2>";
    echo '<a href="javascript:history.back()">Volver al formulario</a>';
    exit;

}


// ======================================================
// VERIFICAR QUE LA DISPONIBILIDAD EXISTA Y ESTÉ DISPONIBLE
// ======================================================

$sql = "SELECT *
        FROM disponibilidad
        WHERE id_disponibilidad = ?
        AND estado = 'DISPONIBLE'
        LIMIT 1";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id_disponibilidad);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {

    echo "<h2>La fecha seleccionada ya no está disponible.</h2>";
    echo '<a href="calendario.php">Volver al calendario</a>';
    exit;

}

$stmt->close();


// ======================================================
// COMENZAR TRANSACCIÓN
// ======================================================

$conexion->begin_transaction();


try {


    // ==================================================
    // 1. GUARDAR LA BANDA / PROYECTO
    // ==================================================

    $sql = "INSERT INTO banda_proyecto
            (
                nombre,
                genero_estilo,
                descripcion,
                redes_sociales,
                link_musica,
                link_presentacion
            )
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "Error al preparar banda_proyecto: " . $conexion->error
        );
    }

    $stmt->bind_param(
        "ssssss",
        $nombre_banda,
        $genero_estilo,
        $descripcion_proyecto,
        $redes_sociales,
        $link_musica,
        $link_presentacion
    );

    if (!$stmt->execute()) {
        throw new Exception(
            "Error al guardar la banda: " . $stmt->error
        );
    }

    // Obtener ID de la banda recién creada
    $id_banda = $conexion->insert_id;

    $stmt->close();


    // ==================================================
    // 2. GUARDAR LOS DATOS DE CONTACTO
    // ==================================================

    $sql = "INSERT INTO contacto
            (
                id_banda,
                nombre,
                email,
                telefono_whatsapp
            )
            VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "Error al preparar contacto: " . $conexion->error
        );
    }

    $stmt->bind_param(
        "isss",
        $id_banda,
        $nombre_contacto,
        $email,
        $telefono_whatsapp
    );

    if (!$stmt->execute()) {
        throw new Exception(
            "Error al guardar el contacto: " . $stmt->error
        );
    }

    // Obtener ID del contacto recién creado
    $id_contacto = $conexion->insert_id;

    $stmt->close();


    // ==================================================
    // 3. GUARDAR LA PROPUESTA
    // ==================================================

    $sql = "INSERT INTO propuesta
            (
                id_banda,
                id_contacto,
                id_disponibilidad,
                descripcion_propuesta,
                rider_tecnico
            )
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "Error al preparar propuesta: " . $conexion->error
        );
    }

    $stmt->bind_param(
        "iiiss",
        $id_banda,
        $id_contacto,
        $id_disponibilidad,
        $descripcion_propuesta,
        $rider_tecnico
    );

    if (!$stmt->execute()) {
        throw new Exception(
            "Error al guardar la propuesta: " . $stmt->error
        );
    }

    $id_propuesta = $conexion->insert_id;

    $stmt->close();


    // ==================================================
    // CONFIRMAR TODOS LOS CAMBIOS
    // ==================================================

    $conexion->commit();


    // ==================================================
    // MOSTRAR MENSAJE DE ÉXITO
    // ==================================================

    ?>

    <!DOCTYPE html>

    <html lang="es">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Propuesta enviada</title>

        <style>

            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 40px 20px;
            }

            .contenedor {
                max-width: 600px;
                margin: auto;
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                text-align: center;
            }

            h1 {
                color: #2e7d32;
            }

            p {
                font-size: 17px;
                line-height: 1.5;
            }

            .boton {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 20px;
                background-color: #333;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }

            .boton:hover {
                background-color: #555;
            }

        </style>

    </head>

    <body>

        <div class="contenedor">

            <h1>¡Propuesta enviada correctamente!</h1>

            <p>
                La propuesta fue registrada correctamente
                y quedó pendiente de revisión.
            </p>

            <a class="boton" href="calendario.php">
                Volver al calendario
            </a>

        </div>

    </body>

    </html>

    <?php


} catch (Exception $e) {


    // ==================================================
    // SI ALGO FALLA, DESHACER LOS CAMBIOS
    // ==================================================

    $conexion->rollback();


    echo "<h2>Error al enviar la propuesta.</h2>";

    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";

    echo '<a href="javascript:history.back()">Volver al formulario</a>';

}

?>
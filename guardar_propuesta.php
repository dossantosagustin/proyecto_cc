
<?php

include "conexion.php";

// ======================================================
// FUNCIÓN PARA MOSTRAR MENSAJES CON LA ESTÉTICA DEL SITIO
// ======================================================

function mostrarMensaje($titulo, $mensaje, $textoBoton, $enlace, $tipo = "info") {

    $tituloSeguro = htmlspecialchars($titulo, ENT_QUOTES, "UTF-8");
    $mensajeSeguro = htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8");
    $textoBotonSeguro = htmlspecialchars($textoBoton, ENT_QUOTES, "UTF-8");

    $esHistorial = ($enlace === "javascript:history.back()");
    $enlaceSeguro = $esHistorial
        ? "javascript:history.back()"
        : htmlspecialchars($enlace, ENT_QUOTES, "UTF-8");

    $claseIcono = ($tipo === "error") ? "icono error" : "icono";
    $simbolo = ($tipo === "error") ? "!" : "✓";

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $tituloSeguro; ?> | Mil Flores</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --fondo: #111111;
                --panel: #1a1a1a;
                --amarillo: #ffd600;
                --blanco: #f5f2ed;
                --gris: #aaa7a2;
                --borde: #353535;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                padding: 24px;
                background: var(--fondo);
                color: var(--blanco);
                font-family: 'DM Sans', sans-serif;
                display: flex;
                flex-direction: column;
            }

            header {
                width: 100%;
                max-width: 1100px;
                margin: 0 auto;
                padding: 12px 0 25px;
                border-bottom: 1px solid var(--borde);
            }

            .marca {
                display: inline-flex;
                flex-direction: row;
                align-items: center;
                gap: 12px;
                text-decoration: none;
                color: var(--blanco);
                line-height: 1;
            }

            .logo-mil-flores {
                width: 55px;
                height: 55px;
                max-width: 55px;
                object-fit: contain;
                display: block;
                flex-shrink: 0;
            }

            .marca strong {
                font-family: 'Barlow Condensed', sans-serif;
                font-size: 32px;
                font-weight: 900;
                letter-spacing: 1px;
            }

            .marca small {
                margin-top: 5px;
                color: var(--amarillo);
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 3px;
            }

            .marca span {
                display: flex;
                flex-direction: column;
            }

            main {
                flex: 1;
                width: 100%;
                max-width: 650px;
                margin: auto;
                padding: 65px 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .contenedor {
                width: 100%;
                padding: 45px;
                text-align: center;
                background: var(--panel);
                border: 1px solid var(--borde);
                border-top: 4px solid var(--amarillo);
            }

            .icono {
                width: 68px;
                height: 68px;
                margin: 0 auto 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid var(--amarillo);
                border-radius: 50%;
                color: var(--amarillo);
                font-size: 38px;
                font-weight: 700;
            }

            .icono.error {
                border-color: #e36b6b;
                color: #e36b6b;
            }

            .etiqueta {
                margin-bottom: 12px;
                color: var(--amarillo);
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 3px;
                text-transform: uppercase;
            }

            h1 {
                margin: 0 0 18px;
                font-family: 'Barlow Condensed', sans-serif;
                font-size: clamp(32px, 6vw, 46px);
                font-weight: 800;
                line-height: 1.05;
                text-transform: uppercase;
            }

            p {
                margin: 0;
                color: var(--gris);
                font-size: 15px;
                line-height: 1.8;
                overflow-wrap: anywhere;
            }

            .boton {
                display: inline-block;
                margin-top: 30px;
                padding: 15px 24px;
                background: var(--amarillo);
                color: #111;
                font-family: 'DM Sans', sans-serif;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 1px;
                text-decoration: none;
                text-transform: uppercase;
                transition: background 0.2s, transform 0.2s;
            }

            .boton:hover {
                background: var(--blanco);
                transform: translateY(-2px);
            }

            .pie {
                padding-top: 20px;
                border-top: 1px solid var(--borde);
                color: #777;
                font-size: 10px;
                letter-spacing: 2px;
                text-align: center;
                text-transform: uppercase;
            }

            @media (max-width: 600px) {
                body {
                    padding: 16px;
                }

                header {
                    padding-bottom: 20px;
                }

                main {
                    padding: 35px 0;
                }

                .contenedor {
                    padding: 32px 22px;
                }

                .marca strong {
                    font-size: 28px;
                }

                .boton {
                    width: 100%;
                    padding: 15px 12px;
                }
            }
        </style>
    </head>

    <body>

        <header>
            <a href="index.php" class="marca">
                <img
                    src="foto1.jpg"
                    alt="Logo de Mil Flores"
                    class="logo-mil-flores"
                >

                <span>
                    <strong>MIL FLORES</strong>
                    <small>CENTRO CULTURAL</small>
                </span>
            </a>
        </header>

        <main>
            <section class="contenedor">

                <div class="<?php echo $claseIcono; ?>">
                    <?php echo $simbolo; ?>
                </div>

                <div class="etiqueta">MIL FLORES · CENTRO CULTURAL</div>

                <h1><?php echo $tituloSeguro; ?></h1>

                <p><?php echo $mensajeSeguro; ?></p>

                <a class="boton" href="<?php echo $enlaceSeguro; ?>">
                    <?php echo $textoBotonSeguro; ?>
                </a>

            </section>
        </main>

        <div class="pie">
            Música · Cultura · Comunidad
        </div>

    </body>
    </html>
    <?php
}


// ======================================================
// VERIFICAR QUE EL FORMULARIO HAYA SIDO ENVIADO
// ======================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    mostrarMensaje(
        "Acceso no válido",
        "Para enviar una propuesta, tenés que completar el formulario correspondiente.",
        "Volver al calendario",
        "calendario.php",
        "error"
    );

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

    mostrarMensaje(
        "Faltan datos",
        "Revisá el formulario y completá todos los campos obligatorios antes de volver a enviarlo.",
        "Volver al formulario",
        "javascript:history.back()",
        "error"
    );

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
    mostrarMensaje(
        "Error del sistema",
        "No se pudo verificar la disponibilidad. Intentá nuevamente más tarde.",
        "Volver al calendario",
        "calendario.php",
        "error"
    );

    exit;
}

$stmt->bind_param("i", $id_disponibilidad);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {

    $stmt->close();

    mostrarMensaje(
        "Fecha no disponible",
        "La fecha seleccionada ya no está disponible. Volvé al calendario para consultar otras fechas.",
        "Volver al calendario",
        "calendario.php",
        "error"
    );

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

    mostrarMensaje(
        "¡Propuesta enviada!",
        "Tu propuesta fue registrada correctamente y quedó pendiente de revisión por parte del equipo de Mil Flores.",
        "Volver al calendario",
        "calendario.php",
        "exito"
    );


} catch (Exception $e) {

    // ==================================================
    // SI ALGO FALLA, DESHACER LOS CAMBIOS
    // ==================================================

    $conexion->rollback();

    error_log("Error al guardar propuesta: " . $e->getMessage());

    mostrarMensaje(
        "No se pudo enviar",
        "Ocurrió un problema al registrar tu propuesta. Tus datos no se guardaron correctamente. Volvé al formulario e intentá nuevamente.",
        "Volver al formulario",
        "javascript:history.back()",
        "error"
    );

}

?>

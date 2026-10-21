
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

    $stmt->close();
}

// Si no existe una disponibilidad válida
if (!$disponibilidad) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fecha no disponible | Mil Flores</title>
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                box-sizing: border-box;
                background: #111;
                color: #f5f2ed;
                font-family: Arial, sans-serif;
            }

            .mensaje {
                width: 100%;
                max-width: 500px;
                padding: 35px;
                box-sizing: border-box;
                border: 1px solid #353535;
                border-top: 4px solid #ffd600;
                border-radius: 5px;
                background: #1a1a1a;
                text-align: center;
            }

            h1 {
                color: #ffd600;
                font-size: 28px;
            }

            p {
                color: #aaa7a2;
                line-height: 1.7;
            }

            a {
                display: inline-block;
                margin-top: 15px;
                padding: 13px 20px;
                background: #ffd600;
                color: #111;
                border-radius: 3px;
                font-weight: bold;
                text-decoration: none;
            }

            a:hover {
                background: #fff;
            }
        </style>
    </head>
    <body>
        <div class="mensaje">
            <h1>Fecha no disponible</h1>
            <p>
                La fecha seleccionada ya no está disponible o no existe.
                Volvé al calendario para elegir otra fecha.
            </p>
            <a href="calendario.php">VOLVER AL CALENDARIO</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#111111">

    <title>Enviar propuesta | Mil Flores Centro Cultural</title>

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
            background: var(--fondo);
            color: var(--blanco);
            font-family: 'DM Sans', Arial, sans-serif;
        }

        a {
            color: inherit;
        }

        /* ENCABEZADO */

        .encabezado {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 18px 7%;
            background: #0c0c0c;
            border-bottom: 1px solid #292929;
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-mil-flores {
            width: 55px;
            height: 55px;
            max-width: 55px;
            object-fit: contain;
            display: block;
            flex-shrink: 0;
        }

        .logo-texto strong {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: 1px;
        }

        .logo-texto small {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            letter-spacing: 4px;
        }

        .menu a {
            color: var(--blanco);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .menu a:hover {
            color: var(--amarillo);
        }

        /* PRESENTACIÓN */

        .intro {
            padding: 50px 20px 40px;
            text-align: center;
            background:
                radial-gradient(ellipse at top, #292719 0%, #111 70%);
        }

        .etiqueta {
            color: var(--amarillo);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        h1, h2 {
            font-family: 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }

        h1 {
            margin: 15px 0;
            font-size: clamp(42px, 7vw, 68px);
            font-weight: 900;
            line-height: 0.95;
        }

        .intro p {
            max-width: 600px;
            margin: 18px auto 0;
            color: var(--gris);
            font-size: 15px;
            line-height: 1.8;
        }

        /* FORMULARIO */

        .contenedor {
            width: min(760px, 92%);
            margin: 0 auto;
            padding: 0 0 70px;
        }

        .formulario {
            padding: 35px;
            border: 1px solid var(--borde);
            border-radius: 5px;
            background: var(--panel);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .fecha {
            margin-bottom: 35px;
            padding: 20px;
            border: 1px solid #6b5e1b;
            border-left: 4px solid var(--amarillo);
            border-radius: 3px;
            background: #292615;
        }

        .fecha-titulo {
            margin-bottom: 10px;
            color: var(--amarillo);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 23px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .fecha p {
            margin: 7px 0;
            color: #dedbd3;
            font-size: 14px;
            line-height: 1.6;
        }

        .seccion-formulario {
            margin-top: 35px;
            padding-top: 10px;
        }

        .seccion-formulario h2 {
            margin: 0 0 8px;
            color: var(--amarillo);
            font-size: 30px;
        }

        .ayuda {
            margin: 0 0 22px;
            color: var(--gris);
            font-size: 13px;
            line-height: 1.7;
        }

        .campo {
            margin-bottom: 21px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: var(--blanco);
            font-size: 13px;
            font-weight: 700;
        }

        .opcional {
            color: var(--gris);
            font-size: 11px;
            font-weight: 400;
        }

        input,
        textarea {
            display: block;
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #454545;
            border-radius: 3px;
            outline: none;
            background: #111;
            color: var(--blanco);
            font-family: 'DM Sans', Arial, sans-serif;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        textarea:focus {
            border-color: var(--amarillo);
            box-shadow: 0 0 0 2px rgba(255, 214, 0, 0.12);
        }

        input::placeholder,
        textarea::placeholder {
            color: #777;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .nota {
            margin-top: 7px;
            color: var(--gris);
            font-size: 11px;
            line-height: 1.6;
        }

        .acciones {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid var(--borde);
        }

        button {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--amarillo);
            border-radius: 3px;
            background: var(--amarillo);
            color: #111;
            cursor: pointer;
            font-family: 'DM Sans', Arial, sans-serif;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            transition: background 0.2s, color 0.2s;
        }

        button:hover {
            background: transparent;
            color: var(--amarillo);
        }

        .volver {
            display: inline-block;
            margin-bottom: 25px;
            color: var(--gris);
            font-size: 12px;
            text-decoration: none;
        }

        .volver:hover {
            color: var(--amarillo);
        }

        .aviso {
            margin-top: 18px;
            color: var(--gris);
            font-size: 11px;
            line-height: 1.7;
            text-align: center;
        }

        /* ADAPTACIÓN A CELULARES */

        @media (max-width: 600px) {

            .encabezado {
                flex-direction: column;
                padding: 18px 5%;
            }

            .formulario {
                padding: 22px 17px;
            }

            .intro {
                padding: 40px 20px 30px;
            }

            .intro p {
                font-size: 14px;
            }

            .fecha {
                padding: 16px;
            }

            .seccion-formulario h2 {
                font-size: 27px;
            }

        }

    </style>

</head>

<body>

<header class="encabezado">
    <a href="index.php" class="marca">
        <img
            src="foto1.jpg"
            alt="Logo de Mil Flores"
            class="logo-mil-flores"
        >

        <span class="logo-texto">
            <strong>MIL FLORES</strong>
            <small>CENTRO CULTURAL</small>
        </span>
    </a>

    <nav class="menu">
        <a href="index.php">INICIO</a>
        <a href="calendario.php">CALENDARIO</a>
    </nav>
</header>

<main>

    <section class="intro">

        <div class="etiqueta">Mil Flores · Berazategui</div>

        <h1>Presentá tu propuesta</h1>

        <p>
            Queremos conocer tu proyecto. Completá el formulario con
            la información de tu banda y contanos qué te gustaría
            hacer en nuestro espacio.
        </p>

    </section>

    <div class="contenedor">

        <a class="volver" href="calendario.php">
            ← Volver al calendario
        </a>

        <div class="formulario">

            <div class="fecha">

                <div class="fecha-titulo">Fecha seleccionada</div>

                <p>
                    <strong>Fecha:</strong>
                    <?php echo htmlspecialchars($disponibilidad['fecha']); ?>
                </p>

                <p>
                    <strong>Horario:</strong>
                    <?php echo htmlspecialchars($disponibilidad['hora_inicio']); ?>
                    -
                    <?php echo htmlspecialchars($disponibilidad['hora_fin']); ?>
                </p>

            </div>

            <form action="guardar_propuesta.php" method="POST">

                <input
                    type="hidden"
                    name="id_disponibilidad"
                    value="<?php echo (int)$disponibilidad['id_disponibilidad']; ?>"
                >

                <!-- DATOS DEL PROYECTO -->

                <section class="seccion-formulario">

                    <h2>01. El proyecto</h2>

                    <p class="ayuda">
                        Contanos quiénes son y dónde podemos escuchar su música.
                    </p>

                    <div class="campo">
                        <label for="nombre_banda">
                            Nombre de la banda o proyecto *
                        </label>

                        <input
                            type="text"
                            id="nombre_banda"
                            name="nombre_banda"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="genero_estilo">
                            Género o estilo musical *
                        </label>

                        <input
                            type="text"
                            id="genero_estilo"
                            name="genero_estilo"
                            maxlength="100"
                            placeholder="Rock, punk, indie, electrónica..."
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="descripcion_proyecto">
                            Descripción del proyecto *
                        </label>

                        <textarea
                            id="descripcion_proyecto"
                            name="descripcion_proyecto"
                            rows="5"
                            placeholder="¿Quiénes son? ¿Qué hacen? ¿Qué los caracteriza?"
                            required
                        ></textarea>
                    </div>

                    <div class="campo">
                        <label for="redes_sociales">
                            Redes sociales
                            <span class="opcional">(opcional)</span>
                        </label>

                        <input
                            type="text"
                            id="redes_sociales"
                            name="redes_sociales"
                            maxlength="255"
                            placeholder="Instagram, TikTok, etc."
                        >
                    </div>

                    <div class="campo">
                        <label for="link_musica">
                            Link para escuchar música *
                        </label>

                        <input
                            type="url"
                            id="link_musica"
                            name="link_musica"
                            maxlength="500"
                            placeholder="https://..."
                            required
                        >

                        <div class="nota">
                            Spotify, YouTube, Bandcamp u otra plataforma.
                        </div>
                    </div>

                    <div class="campo">
                        <label for="link_presentacion">
                            Link a una presentación en vivo
                            <span class="opcional">(opcional)</span>
                        </label>

                        <input
                            type="url"
                            id="link_presentacion"
                            name="link_presentacion"
                            maxlength="500"
                            placeholder="https://..."
                        >
                    </div>

                </section>

                <!-- DATOS DE CONTACTO -->

                <section class="seccion-formulario">

                    <h2>02. Contacto</h2>

                    <p class="ayuda">
                        Necesitamos una persona de referencia para comunicarnos.
                    </p>

                    <div class="campo">
                        <label for="nombre_contacto">
                            Nombre y apellido *
                        </label>

                        <input
                            type="text"
                            id="nombre_contacto"
                            name="nombre_contacto"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="email">
                            Email *
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            maxlength="150"
                            placeholder="nombre@correo.com"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="telefono_whatsapp">
                            Teléfono / WhatsApp *
                        </label>

                        <input
                            type="tel"
                            id="telefono_whatsapp"
                            name="telefono_whatsapp"
                            maxlength="50"
                            placeholder="Código de área + número"
                            required
                        >
                    </div>

                </section>

                <!-- PROPUESTA -->

                <section class="seccion-formulario">

                    <h2>03. La propuesta</h2>

                    <p class="ayuda">
                        Esta es la parte más importante: queremos saber qué
                        actividad les gustaría realizar en Mil Flores.
                    </p>

                    <div class="campo">
                        <label for="descripcion_propuesta">
                            ¿Qué propuesta les gustaría realizar en el Centro Cultural? *
                        </label>

                        <textarea
                            id="descripcion_propuesta"
                            name="descripcion_propuesta"
                            rows="6"
                            placeholder="Contanos la idea, el formato del show o la actividad que imaginan..."
                            required
                        ></textarea>
                    </div>

                    <div class="campo">
                        <label for="rider_tecnico">
                            Rider técnico
                            <span class="opcional">(opcional)</span>
                        </label>

                        <textarea
                            id="rider_tecnico"
                            name="rider_tecnico"
                            rows="4"
                            placeholder="Instrumentos, micrófonos, amplificación y otras necesidades técnicas..."
                        ></textarea>
                    </div>

                </section>

                <div class="acciones">

                    <button type="submit">
                        ENVIAR PROPUESTA →
                    </button>

                    <p class="aviso">
                        El envío de la propuesta no confirma la realización
                        del evento. El Centro Cultural revisará la solicitud.
                    </p>

                </div>

            </form>

        </div>

    </div>

</main>

</body>
</html>

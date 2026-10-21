
<?php

include "conexion.php";

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : intval(date('m'));
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : intval(date('Y'));

if ($mes < 1) {
    $mes = 12;
    $anio--;
}

if ($mes > 12) {
    $mes = 1;
    $anio++;
}

$sql = "SELECT fecha, hora_inicio, hora_fin, estado, observaciones
        FROM disponibilidad
        ORDER BY fecha";

$resultado = $conexion->query($sql);

$disponibilidades = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $disponibilidades[$fila['fecha']] = $fila;
    }
}

$nombres_meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
    4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
    7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
    10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$nombre_mes = $nombres_meses[$mes];

$primer_dia = mktime(0, 0, 0, $mes, 1, $anio);
$cantidad_dias = date('t', $primer_dia);
$dia_semana = date('N', $primer_dia);

$mes_anterior = $mes - 1;
$anio_anterior = $anio;

if ($mes_anterior < 1) {
    $mes_anterior = 12;
    $anio_anterior--;
}

$mes_siguiente = $mes + 1;
$anio_siguiente = $anio;

if ($mes_siguiente > 12) {
    $mes_siguiente = 1;
    $anio_siguiente++;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#111111">
    <title>Calendario | Mil Flores Centro Cultural</title>

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

        html {
            scroll-behavior: smooth;
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
            justify-content: space-between;
            align-items: center;
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

        .menu {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .menu a {
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
            padding: 55px 20px 35px;
            text-align: center;
            background:
                radial-gradient(ellipse at top, #292719 0%, #111111 70%);
        }

        .etiqueta {
            color: var(--amarillo);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        h1, h2, h3 {
            font-family: 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }

        h1 {
            margin: 14px 0;
            font-size: clamp(42px, 7vw, 70px);
            font-weight: 900;
            line-height: 0.95;
        }

        .intro p {
            max-width: 580px;
            margin: 18px auto 0;
            color: var(--gris);
            font-size: 15px;
            line-height: 1.8;
        }

        /* CONTENIDO DEL CALENDARIO */

        .contenido {
            width: min(1050px, 92%);
            margin: 0 auto;
            padding: 15px 0 70px;
        }

        .leyenda {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 0 0 25px;
            color: var(--gris);
            font-size: 12px;
        }

        .leyenda span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .punto {
            width: 11px;
            height: 11px;
            display: inline-block;
            border-radius: 2px;
        }

        .punto-disponible {
            background: var(--amarillo);
        }

        .punto-ocupado {
            background: #8b4545;
        }

        .punto-sin-datos {
            background: #444;
        }

        .calendario {
            padding: 25px;
            border: 1px solid var(--borde);
            border-radius: 5px;
            background: var(--panel);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .navegacion {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .navegacion .mes {
            color: var(--amarillo);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(24px, 4vw, 34px);
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
        }

        .nav-boton {
            display: inline-block;
            width: fit-content;
            padding: 10px 13px;
            border: 1px solid #555;
            border-radius: 3px;
            background: #242424;
            color: var(--blanco);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s;
        }

        .nav-boton:last-child {
            justify-self: end;
        }

        .nav-boton:hover {
            border-color: var(--amarillo);
            color: var(--amarillo);
        }

        .dias {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 7px;
        }

        .dia-semana {
            padding: 10px 0;
            color: var(--gris);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-align: center;
            text-transform: uppercase;
        }

        .dia {
            min-width: 0;
            min-height: 90px;
            padding: 12px 10px;
            overflow-wrap: anywhere;
            border: 1px solid #383838;
            border-radius: 3px;
            background: #222;
            color: var(--blanco);
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.2s;
        }

        .dia:hover {
            transform: translateY(-2px);
            border-color: var(--amarillo);
            background: #303020;
        }

        .dia.disponible {
            border-color: #756719;
            background: #302c17;
        }

        .dia.disponible:hover {
            border-color: var(--amarillo);
            background: #48401b;
        }

        .dia.ocupado {
            border-color: #563535;
            background: #2c2020;
        }

        .dia.sin-datos {
            background: #191919;
        }

        .numero {
            display: block;
            margin-bottom: 10px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 26px;
            font-weight: 800;
        }

        .disponible .numero {
            color: var(--amarillo);
        }

        .dia small {
            display: block;
            color: #d0cbc1;
            font-size: 10px;
            line-height: 1.4;
            text-transform: uppercase;
        }

        /* INFORMACIÓN DE LA FECHA */

        .informacion {
            margin-top: 25px;
            padding: 28px;
            border: 1px solid var(--borde);
            border-left: 4px solid var(--amarillo);
            border-radius: 4px;
            background: var(--panel);
            scroll-margin-top: 20px;
        }

        .informacion h2 {
            margin: 0 0 18px;
            color: var(--amarillo);
            font-size: 34px;
        }

        .informacion p {
            color: #d1cec8;
            font-size: 14px;
            line-height: 1.8;
        }

        .estado {
            display: inline-block;
            padding: 6px 10px;
            border: 1px solid #6b5e1b;
            border-radius: 3px;
            background: #302c17;
            color: var(--amarillo);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .boton {
            display: inline-block;
            margin-top: 12px;
            padding: 14px 20px;
            border: 2px solid var(--amarillo);
            border-radius: 3px;
            background: var(--amarillo);
            color: #111;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 1px;
            text-decoration: none;
            transition: 0.2s;
        }

        .boton:hover {
            background: transparent;
            color: var(--amarillo);
        }

        .volver {
            display: inline-block;
            margin-top: 30px;
            color: var(--gris);
            font-size: 12px;
            text-decoration: none;
        }

        .volver:hover {
            color: var(--amarillo);
        }

        @media (max-width: 700px) {
            .encabezado {
                flex-direction: column;
                padding: 18px 5%;
            }

            .menu {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px 22px;
            }

            .contenido {
                width: 96%;
            }

            .calendario {
                padding: 12px;
            }

            .navegacion {
                grid-template-columns: 1fr 1fr;
            }

            .navegacion .mes {
                grid-column: 1 / -1;
                grid-row: 1;
            }

            .navegacion a {
                grid-row: 2;
            }

            .dia {
                min-height: 65px;
                padding: 7px 4px;
            }

            .dia-semana {
                font-size: 9px;
                letter-spacing: 0;
            }

            .numero {
                font-size: 21px;
                margin-bottom: 5px;
            }

            .dia small {
                font-size: 8px;
            }

            .informacion {
                padding: 20px;
            }
        }

        @media (max-width: 380px) {
            .calendario {
                padding: 7px;
            }

            .dias {
                gap: 3px;
            }

            .dia {
                min-height: 57px;
                padding: 5px 2px;
            }

            .dia small {
                font-size: 7px;
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
        
        <h1>Calendario de fechas</h1>
        <p>
            Consultá la disponibilidad del espacio y encontrá una fecha
            para presentar tu banda, proyecto musical o propuesta artística.
        </p>
    </section>

    <div class="contenido">

        <div class="leyenda">
            <span><i class="punto punto-disponible"></i> Disponible</span>
            <span><i class="punto punto-ocupado"></i> No disponible</span>
            <span><i class="punto punto-sin-datos"></i> Sin información</span>
        </div>

        <section class="calendario">

            <div class="navegacion">

                <a class="nav-boton"
                   href="?mes=<?php echo $mes_anterior; ?>&anio=<?php echo $anio_anterior; ?>">
                    ← Mes anterior
                </a>

                <div class="mes">
                    <?php echo htmlspecialchars($nombre_mes . " " . $anio); ?>
                </div>

                <a class="nav-boton"
                   href="?mes=<?php echo $mes_siguiente; ?>&anio=<?php echo $anio_siguiente; ?>">
                    Mes siguiente →
                </a>

            </div>

            <div class="dias">

                <div class="dia-semana">Lun</div>
                <div class="dia-semana">Mar</div>
                <div class="dia-semana">Mié</div>
                <div class="dia-semana">Jue</div>
                <div class="dia-semana">Vie</div>
                <div class="dia-semana">Sáb</div>
                <div class="dia-semana">Dom</div>

                <?php

                for ($i = 1; $i < $dia_semana; $i++) {
                    echo '<div></div>';
                }

                for ($dia = 1; $dia <= $cantidad_dias; $dia++) {

                    $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

                    $clase = "sin-datos";

                    if (isset($disponibilidades[$fecha])) {
                        if (strtolower($disponibilidades[$fecha]['estado']) == 'disponible') {
                            $clase = "disponible";
                        } else {
                            $clase = "ocupado";
                        }
                    }

                    echo '<div class="dia ' . $clase . '" role="button" tabindex="0" onclick="mostrarInfo(\'' . $fecha . '\')" onkeydown="if(event.key === \'Enter\' || event.key === \' \'){event.preventDefault(); mostrarInfo(\'' . $fecha . '\')}">';

                    echo '<span class="numero">' . $dia . '</span>';

                    if (isset($disponibilidades[$fecha])) {
                        echo '<small>' . htmlspecialchars($disponibilidades[$fecha]['estado']) . '</small>';
                    }

                    echo '</div>';
                }

                ?>

            </div>

        </section>

        <section class="informacion" id="informacion" aria-live="polite">

            <div class="etiqueta">Fecha seleccionada</div>

            <h2>Elegí un día</h2>

            <p>
                Hacé clic en cualquier fecha del calendario para consultar
                el estado y el horario. Las fechas disponibles te permiten
                enviar una propuesta.
            </p>

        </section>

        <a href="index.php" class="volver">← Volver a la página principal</a>

    </div>

</main>

<script>
const disponibilidades = <?php
    echo json_encode(
        $disponibilidades,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
    );
?>;

function escaparHTML(valor) {
    return String(valor ?? '').replace(/[&<>"']/g, function(caracter) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[caracter];
    });
}

function mostrarInfo(fecha) {

    const informacion = document.getElementById("informacion");
    const datos = disponibilidades[fecha];

    if (datos) {

        let boton = "";

        if (String(datos.estado).toLowerCase() === "disponible") {
            boton = `
                <a href="propuesta.php?fecha=${encodeURIComponent(fecha)}"
                   class="boton">
                    ENVIAR PROPUESTA →
                </a>
            `;
        }

        informacion.innerHTML = `
            <div class="etiqueta">Fecha seleccionada</div>
            <h2>${escaparHTML(fecha)}</h2>

            <p>
                <strong>Estado:</strong>
                <span class="estado">${escaparHTML(datos.estado)}</span>
            </p>

            <p>
                <strong>Horario:</strong>
                ${escaparHTML(datos.hora_inicio)} - ${escaparHTML(datos.hora_fin)}
            </p>

            <p>
                <strong>Observaciones:</strong>
                ${escaparHTML(datos.observaciones || 'Sin observaciones')}
            </p>

            ${boton}
        `;

    } else {

        informacion.innerHTML = `
            <div class="etiqueta">Fecha seleccionada</div>
            <h2>${escaparHTML(fecha)}</h2>
            <p>
                No hay información de disponibilidad para esta fecha.
            </p>
        `;
    }

    // Desplazamiento suave hasta la información.
    requestAnimationFrame(() => {
        informacion.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    });
}
</script>

</body>
</html>

<?php

require_once("proteccion_admin.php");

include("conexion.php");

/* ==============================
   MESES
============================== */

$nombres_meses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];

/* ==============================
   MES Y AÑO ACTUAL
============================== */

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : intval(date('n'));
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : intval(date('Y'));

/* Evitar meses inválidos */

if ($mes < 1) {
    $mes = 12;
    $anio--;
}

if ($mes > 12) {
    $mes = 1;
    $anio++;
}

/* ==============================
   CAMBIAR DE MES
============================== */

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

/* ==============================
   PRIMER Y ÚLTIMO DÍA DEL MES
============================== */

$primer_dia = sprintf('%04d-%02d-01', $anio, $mes);
$ultimo_dia = date('Y-m-t', strtotime($primer_dia));

/* ==============================
   OBTENER EVENTOS
============================== */

$sql = "
    SELECT
        e.id_evento,
        e.estado AS estado_evento,

        p.id_propuesta,
        p.descripcion_propuesta,
        p.rider_tecnico,
        p.fecha_envio,
        p.estado AS estado_propuesta,

        b.nombre AS nombre_banda,
        b.genero_estilo,
        b.descripcion AS descripcion_banda,
        b.redes_sociales,
        b.link_musica,
        b.link_presentacion,

        c.nombre AS nombre_contacto,
        c.email,
        c.telefono_whatsapp,

        d.fecha,
        d.hora_inicio,
        d.hora_fin,
        d.estado AS estado_disponibilidad,
        d.observaciones

    FROM evento e

    INNER JOIN propuesta p
        ON e.id_propuesta = p.id_propuesta

    INNER JOIN banda_proyecto b
        ON p.id_banda = b.id_banda

    INNER JOIN contacto c
        ON p.id_contacto = c.id_contacto

    INNER JOIN disponibilidad d
        ON p.id_disponibilidad = d.id_disponibilidad

    WHERE d.fecha BETWEEN ? AND ?

    ORDER BY d.fecha ASC, d.hora_inicio ASC
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $primer_dia, $ultimo_dia);
$stmt->execute();

$resultado = $stmt->get_result();

/* ==============================
   GUARDAR EVENTOS POR FECHA
============================== */

$eventos = [];

while ($evento = $resultado->fetch_assoc()) {

    $fecha = $evento['fecha'];

    if (!isset($eventos[$fecha])) {
        $eventos[$fecha] = [];
    }

    $eventos[$fecha][] = $evento;
}

$stmt->close();

/* ==============================
   DATOS DEL CALENDARIO
============================== */

$primer_dia_semana = date('N', strtotime($primer_dia));

$dias_mes = date('t', strtotime($primer_dia));

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Calendario de eventos</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        /* ==============================
           NAVEGACIÓN
        ============================== */

        .navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .navegacion a {
            text-decoration: none;
            background: #333;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .navegacion a:hover {
            background: #555;
        }

        .mes_actual {
            font-size: 26px;
            font-weight: bold;
        }

        /* ==============================
           CALENDARIO
        ============================== */

        .calendario {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .dias_semana {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #333;
            color: white;
        }

        .dia_semana {
            text-align: center;
            padding: 12px 5px;
            font-weight: bold;
        }

        .dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .dia_vacio {
            min-height: 120px;
            background: #fafafa;
            border: 1px solid #eee;
        }

        .dia {
            min-height: 120px;
            padding: 8px;
            border: 1px solid #eee;
            background: white;
        }

        .numero_dia {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        /* ==============================
           EVENTO
        ============================== */

        .evento {
            background: #dbeafe;
            border-left: 5px solid #2563eb;
            padding: 7px;
            margin-bottom: 6px;
            border-radius: 5px;
            cursor: pointer;
        }

        .evento:hover {
            background: #bfdbfe;
        }

        .evento_nombre {
            font-weight: bold;
            font-size: 14px;
        }

        .evento_hora {
            font-size: 12px;
            margin-top: 3px;
        }

        /* ==============================
           SIN EVENTO
        ============================== */

        .sin_evento {
            color: #aaa;
            font-size: 12px;
        }

        /* ==============================
           DETALLE
        ============================== */

        .detalle {
            display: none;
            margin-top: 30px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .detalle.activo {
            display: block;
        }

        .detalle h2 {
            margin-top: 0;
        }

        .dato {
            margin-bottom: 12px;
        }

        .dato strong {
            display: inline-block;
            min-width: 170px;
        }

        .cerrar {
            float: right;
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .cerrar:hover {
            background: #b91c1c;
        }

        .estado {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
        }

        /* ==============================
           REFERENCIAS
        ============================== */

        .referencias {
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
        }

        .referencia {
            display: inline-block;
            margin-right: 20px;
        }

        .cuadrado {
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-right: 5px;
            vertical-align: middle;
            border-radius: 3px;
        }

        .azul {
            background: #2563eb;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>📅 Calendario de eventos</h1>

    <!-- ==============================
         NAVEGACIÓN
    ============================== -->

    <div class="navegacion">

        <a href="admin_eventos.php?mes=<?php echo $mes_anterior; ?>&anio=<?php echo $anio_anterior; ?>">
            ← Mes anterior
        </a>

        <div class="mes_actual">
            <?php echo $nombres_meses[$mes] . ' ' . $anio; ?>
        </div>

        <a href="admin_eventos.php?mes=<?php echo $mes_siguiente; ?>&anio=<?php echo $anio_siguiente; ?>">
            Mes siguiente →
        </a>

    </div>


    <!-- ==============================
         CALENDARIO
    ============================== -->

    <div class="calendario">

        <div class="dias_semana">

            <div class="dia_semana">Lun</div>
            <div class="dia_semana">Mar</div>
            <div class="dia_semana">Mié</div>
            <div class="dia_semana">Jue</div>
            <div class="dia_semana">Vie</div>
            <div class="dia_semana">Sáb</div>
            <div class="dia_semana">Dom</div>

        </div>


        <div class="dias">

            <?php

            /* Espacios antes del primer día */

            for ($i = 1; $i < $primer_dia_semana; $i++) {
                echo '<div class="dia_vacio"></div>';
            }


            /* Días del mes */

            for ($dia = 1; $dia <= $dias_mes; $dia++) {

                $fecha_actual = sprintf(
                    '%04d-%02d-%02d',
                    $anio,
                    $mes,
                    $dia
                );

                ?>

                <div class="dia">

                    <div class="numero_dia">
                        <?php echo $dia; ?>
                    </div>


                    <?php

                    if (isset($eventos[$fecha_actual])) {

                        foreach ($eventos[$fecha_actual] as $indice => $evento) {

                            $id_detalle = 'evento_' . $dia . '_' . $indice;

                            ?>

                            <div
                                class="evento"
                                onclick="mostrarEvento('<?php echo $id_detalle; ?>')"
                            >

                                <div class="evento_nombre">
                                    🎵 <?php echo htmlspecialchars($evento['nombre_banda']); ?>
                                </div>

                                <div class="evento_hora">
                                    🕐
                                    <?php
                                    echo date(
                                        'H:i',
                                        strtotime($evento['hora_inicio'])
                                    );
                                    ?>
                                    -
                                    <?php
                                    echo date(
                                        'H:i',
                                        strtotime($evento['hora_fin'])
                                    );
                                    ?>
                                </div>

                            </div>


                            <!-- ==============================
                                 DATOS OCULTOS DEL EVENTO
                            ============================== -->

                            <div
                                id="<?php echo $id_detalle; ?>"
                                class="datos_evento"
                                style="display:none;"
                            >

                                <span class="fecha">
                                    <?php
                                    echo date(
                                        'd/m/Y',
                                        strtotime($evento['fecha'])
                                    );
                                    ?>
                                </span>

                                <span class="hora_inicio">
                                    <?php
                                    echo date(
                                        'H:i',
                                        strtotime($evento['hora_inicio'])
                                    );
                                    ?>
                                </span>

                                <span class="hora_fin">
                                    <?php
                                    echo date(
                                        'H:i',
                                        strtotime($evento['hora_fin'])
                                    );
                                    ?>
                                </span>

                                <span class="nombre_banda">
                                    <?php echo htmlspecialchars($evento['nombre_banda']); ?>
                                </span>

                                <span class="genero">
                                    <?php echo htmlspecialchars($evento['genero_estilo']); ?>
                                </span>

                                <span class="contacto">
                                    <?php echo htmlspecialchars($evento['nombre_contacto']); ?>
                                </span>

                                <span class="email">
                                    <?php echo htmlspecialchars($evento['email']); ?>
                                </span>

                                <span class="telefono">
                                    <?php echo htmlspecialchars($evento['telefono_whatsapp']); ?>
                                </span>

                                <span class="descripcion_banda">
                                    <?php echo htmlspecialchars($evento['descripcion_banda']); ?>
                                </span>

                                <span class="descripcion_propuesta">
                                    <?php echo htmlspecialchars($evento['descripcion_propuesta']); ?>
                                </span>

                                <span class="rider">
                                    <?php echo htmlspecialchars($evento['rider_tecnico'] ?? 'No especificado'); ?>
                                </span>

                                <span class="estado_evento">
                                    <?php echo htmlspecialchars($evento['estado_evento']); ?>
                                </span>

                            </div>

                            <?php

                        }

                    } else {

                        ?>

                        <div class="sin_evento">
                            Sin evento
                        </div>

                        <?php

                    }

                    ?>

                </div>

                <?php

            }

            ?>

        </div>

    </div>


    <!-- ==============================
         REFERENCIAS
    ============================== -->

    <div class="referencias">

        <div class="referencia">
            <span class="cuadrado azul"></span>
            Evento programado
        </div>

    </div>


    <!-- ==============================
         DETALLE DEL EVENTO
    ============================== -->

    <div id="detalle" class="detalle">

        <button class="cerrar" onclick="cerrarDetalle()">
            Cerrar
        </button>

        <h2>🎵 Detalle del evento</h2>

        <div class="dato">
            <strong>📅 Fecha:</strong>
            <span id="detalle_fecha"></span>
        </div>

        <div class="dato">
            <strong>🕐 Horario:</strong>
            <span id="detalle_horario"></span>
        </div>

        <div class="dato">
            <strong>🎸 Banda / Proyecto:</strong>
            <span id="detalle_banda"></span>
        </div>

        <div class="dato">
            <strong>🎼 Género / Estilo:</strong>
            <span id="detalle_genero"></span>
        </div>

        <hr>

        <h3>👤 Contacto</h3>

        <div class="dato">
            <strong>Nombre:</strong>
            <span id="detalle_contacto"></span>
        </div>

        <div class="dato">
            <strong>Email:</strong>
            <span id="detalle_email"></span>
        </div>

        <div class="dato">
            <strong>Teléfono / WhatsApp:</strong>
            <span id="detalle_telefono"></span>
        </div>

        <hr>

        <h3>📝 Información</h3>

        <div class="dato">
            <strong>Descripción de la banda:</strong>
            <span id="detalle_descripcion_banda"></span>
        </div>

        <div class="dato">
            <strong>Propuesta:</strong>
            <span id="detalle_propuesta"></span>
        </div>

        <div class="dato">
            <strong>Rider técnico:</strong>
            <span id="detalle_rider"></span>
        </div>

        <div class="dato">
            <strong>Estado:</strong>
            <span class="estado" id="detalle_estado"></span>
        </div>

    </div>

</div>


<script>

/* ==============================
   MOSTRAR EVENTO
============================== */

function mostrarEvento(id) {

    const elemento = document.getElementById(id);

    document.getElementById("detalle_fecha").textContent =
        elemento.querySelector(".fecha").textContent;

    document.getElementById("detalle_horario").textContent =
        elemento.querySelector(".hora_inicio").textContent +
        " - " +
        elemento.querySelector(".hora_fin").textContent;

    document.getElementById("detalle_banda").textContent =
        elemento.querySelector(".nombre_banda").textContent;

    document.getElementById("detalle_genero").textContent =
        elemento.querySelector(".genero").textContent;

    document.getElementById("detalle_contacto").textContent =
        elemento.querySelector(".contacto").textContent;

    document.getElementById("detalle_email").textContent =
        elemento.querySelector(".email").textContent;

    document.getElementById("detalle_telefono").textContent =
        elemento.querySelector(".telefono").textContent;

    document.getElementById("detalle_descripcion_banda").textContent =
        elemento.querySelector(".descripcion_banda").textContent;

    document.getElementById("detalle_propuesta").textContent =
        elemento.querySelector(".descripcion_propuesta").textContent;

    document.getElementById("detalle_rider").textContent =
        elemento.querySelector(".rider").textContent;

    document.getElementById("detalle_estado").textContent =
        elemento.querySelector(".estado_evento").textContent;

    document.getElementById("detalle").classList.add("activo");

    window.scrollTo({
        top: document.getElementById("detalle").offsetTop - 20,
        behavior: "smooth"
    });
}


/* ==============================
   CERRAR DETALLE
============================== */

function cerrarDetalle() {

    document.getElementById("detalle").classList.remove("activo");

}

</script>

</body>

</html>
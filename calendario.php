<?php

include "conexion.php";

// Obtener el mes y año desde la URL.
// Si no existen, usamos el mes actual.
$mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('m');
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : date('Y');

// Ajustar si el mes es menor que 1 o mayor que 12
if ($mes < 1) {
    $mes = 12;
    $anio--;
}

if ($mes > 12) {
    $mes = 1;
    $anio++;
}


// Obtener las disponibilidades de la base de datos
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


// Nombres de los meses
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

$nombre_mes = $nombres_meses[$mes];


// Calcular el primer día del mes
$primer_dia = mktime(0, 0, 0, $mes, 1, $anio);

// Cantidad de días del mes
$cantidad_dias = date('t', $primer_dia);

// Día de la semana del primer día
// 1 = lunes, 7 = domingo
$dia_semana = date('N', $primer_dia);


// Mes anterior
$mes_anterior = $mes - 1;
$anio_anterior = $anio;

if ($mes_anterior < 1) {
    $mes_anterior = 12;
    $anio_anterior--;
}


// Mes siguiente
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

    <title>Calendario de disponibilidad</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        .calendario {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        /* Navegación entre meses */

        .navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .navegacion a {
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .navegacion a:hover {
            background-color: #555;
        }

        .mes {
            font-size: 24px;
            font-weight: bold;
        }


        /* Calendario */

        .dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .dia-semana {
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }

        .dia {
            min-height: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        .dia:hover {
            background-color: #eee;
        }

        .disponible {
            background-color: #d4edda;
        }

        .ocupado {
            background-color: #f8d7da;
        }

        .sin-datos {
            background-color: #f8f9fa;
        }

        .numero {
            font-weight: bold;
            font-size: 18px;
        }


        /* Información de la fecha */

        .informacion {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

    </style>

</head>


<body>

<h1>Disponibilidad del Centro Cultural</h1>


<div class="calendario">

    <!-- Navegación entre meses -->

    <div class="navegacion">

        <a href="?mes=<?php echo $mes_anterior; ?>&anio=<?php echo $anio_anterior; ?>">
            ← Mes anterior
        </a>

        <div class="mes">
            <?php echo $nombre_mes . " " . $anio; ?>
        </div>

        <a href="?mes=<?php echo $mes_siguiente; ?>&anio=<?php echo $anio_siguiente; ?>">
            Mes siguiente →
        </a>

    </div>


    <!-- Días de la semana -->

    <div class="dias">

        <div class="dia-semana">Lun</div>
        <div class="dia-semana">Mar</div>
        <div class="dia-semana">Mié</div>
        <div class="dia-semana">Jue</div>
        <div class="dia-semana">Vie</div>
        <div class="dia-semana">Sáb</div>
        <div class="dia-semana">Dom</div>


        <?php

        // Espacios antes del primer día
        for ($i = 1; $i < $dia_semana; $i++) {

            echo '<div></div>';

        }


        // Crear los días del mes
        for ($dia = 1; $dia <= $cantidad_dias; $dia++) {

            $fecha = sprintf(
                '%04d-%02d-%02d',
                $anio,
                $mes,
                $dia
            );


            // Clase por defecto
            $clase = "sin-datos";


            // Si existe disponibilidad para esa fecha
            if (isset($disponibilidades[$fecha])) {

                if (
                    strtolower($disponibilidades[$fecha]['estado'])
                    == 'disponible'
                ) {

                    $clase = "disponible";

                } else {

                    $clase = "ocupado";

                }

            }


            echo '<div class="dia ' . $clase . '" onclick="mostrarInfo(\'' . $fecha . '\')">';

            echo '<div class="numero">' . $dia . '</div>';


            if (isset($disponibilidades[$fecha])) {

                echo '<small>'
                    . htmlspecialchars($disponibilidades[$fecha]['estado'])
                    . '</small>';

            }


            echo '</div>';

        }

        ?>

    </div>

</div>


<!-- Información de la fecha seleccionada -->

<div class="informacion" id="informacion">

    <h2>Seleccioná una fecha</h2>

    <p>
        Hacé clic sobre un día del calendario para consultar la disponibilidad.
    </p>

</div>


<script>

// Datos enviados desde PHP
const disponibilidades =
    <?php echo json_encode($disponibilidades); ?>;


// Mostrar información al seleccionar una fecha
function mostrarInfo(fecha) {

    const informacion =
        document.getElementById("informacion");

    if (disponibilidades[fecha]) {

        const datos =
            disponibilidades[fecha];

        let boton = "";

        // Si la fecha está disponible,
        // mostramos el botón para enviar una propuesta.
        if (datos.estado.toLowerCase() === "disponible") {

            boton = `
                <br>
                <a href="propuesta.php?fecha=${fecha}"
                   style="
                       display: inline-block;
                       background-color: #333;
                       color: white;
                       padding: 10px 15px;
                       border-radius: 5px;
                       text-decoration: none;
                   ">
                    Enviar propuesta
                </a>
            `;
        }

        informacion.innerHTML = `

            <h2>${fecha}</h2>

            <p>
                <strong>Estado:</strong>
                ${datos.estado}
            </p>

            <p>
                <strong>Horario:</strong>
                ${datos.hora_inicio}
                -
                ${datos.hora_fin}
            </p>

            <p>
                <strong>Observaciones:</strong>
                ${datos.observaciones ?? 'Sin observaciones'}
            </p>

            ${boton}

        `;

    } else {

        informacion.innerHTML = `

            <h2>${fecha}</h2>

            <p>
                <strong>
                    No hay información de disponibilidad para esta fecha.
                </strong>
            </p>

        `;

    }

}

</script>


</body>

</html>
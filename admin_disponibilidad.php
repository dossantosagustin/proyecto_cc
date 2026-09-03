<?php

require_once("proteccion_admin.php");

include("conexion.php");


// ======================================================
// EDITAR DISPONIBILIDAD
// ======================================================

if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {

    $id = intval($_POST['id_disponibilidad']);
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $estado = $_POST['estado'];
    $observaciones = $_POST['observaciones'];

    // Verificar que la hora de inicio sea menor que la hora de fin
    if ($hora_inicio >= $hora_fin) {
        die("La hora de inicio debe ser anterior a la hora de finalización.");
    }

    $sql = "UPDATE disponibilidad
            SET fecha = ?,
                hora_inicio = ?,
                hora_fin = ?,
                estado = ?,
                observaciones = ?
            WHERE id_disponibilidad = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la edición: " . $conexion->error);
    }

    $stmt->bind_param(
        "sssssi",
        $fecha,
        $hora_inicio,
        $hora_fin,
        $estado,
        $observaciones,
        $id
    );

    if ($stmt->execute()) {

        header("Location: admin_disponibilidad.php");
        exit;

    } else {

        die("Error al editar la fecha: " . $stmt->error);

    }
}


// ======================================================
// ELIMINAR DISPONIBILIDAD
// ======================================================

if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {

    $id = intval($_POST['id_disponibilidad']);


    // Primero verificamos si hay propuestas relacionadas
    $sql = "SELECT COUNT(*) AS cantidad
            FROM propuesta
            WHERE id_disponibilidad = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al verificar propuestas: " . $conexion->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado_propuestas = $stmt->get_result();
    $fila = $resultado_propuestas->fetch_assoc();


    // Si hay propuestas, no permitimos eliminar
    if ($fila['cantidad'] > 0) {

        die(
            "No se puede eliminar esta fecha porque tiene propuestas asociadas."
        );

    }


    // Si no hay propuestas, eliminamos
    $sql = "DELETE FROM disponibilidad
            WHERE id_disponibilidad = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la eliminación: " . $conexion->error);
    }

    $stmt->bind_param("i", $id);


    if ($stmt->execute()) {

        header("Location: admin_disponibilidad.php");
        exit;

    } else {

        die("Error al eliminar la fecha: " . $stmt->error);

    }
}


// ======================================================
// OBTENER TODAS LAS FECHAS
// ======================================================

$sql = "SELECT 
            id_disponibilidad,
            fecha,
            hora_inicio,
            hora_fin,
            estado,
            observaciones
        FROM disponibilidad
        ORDER BY fecha ASC, hora_inicio ASC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al obtener las fechas: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrar disponibilidad</title>


    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }


        .contenedor {
            max-width: 1000px;
            margin: auto;
        }


        h1 {
            text-align: center;
            margin-bottom: 30px;
        }


        .formulario {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }


        .formulario h2 {
            margin-top: 0;
        }


        .campo {
            margin-bottom: 15px;
        }


        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }


        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }


        .campo textarea {
            resize: vertical;
        }


        .boton {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }


        .boton:hover {
            opacity: 0.85;
        }


        .fecha {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }


        .fecha h3 {
            margin-top: 0;
        }


        .dato {
            margin: 8px 0;
        }


        .dato strong {
            display: inline-block;
            min-width: 150px;
        }


        .estado {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }


        .disponible {
            background-color: #d4edda;
            color: #155724;
        }


        .no-disponible {
            background-color: #f8d7da;
            color: #721c24;
        }


        .sin-fechas {
            background-color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }


        .botones {
            margin-top: 15px;
        }


        .boton-editar {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 8px;
            font-size: 15px;
        }


        .boton-eliminar {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }


        .formulario-edicion {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
        }


        .formulario-edicion h3 {
            margin-top: 0;
        }


        .boton-guardar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

    </style>

</head>


<body>


<div class="contenedor">


    <h1>Administrar disponibilidad</h1>


    <!-- ==================================================
         FORMULARIO PARA AGREGAR UNA FECHA
         ================================================== -->

    <div class="formulario">

        <h2>Agregar nueva fecha</h2>


        <form action="guardar_disponibilidad.php" method="POST">


            <div class="campo">

                <label for="fecha">
                    Fecha:
                </label>

                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    required
                >

            </div>


            <div class="campo">

                <label for="hora_inicio">
                    Hora de inicio:
                </label>

                <input
                    type="time"
                    id="hora_inicio"
                    name="hora_inicio"
                    required
                >

            </div>


            <div class="campo">

                <label for="hora_fin">
                    Hora de finalización:
                </label>

                <input
                    type="time"
                    id="hora_fin"
                    name="hora_fin"
                    required
                >

            </div>


            <div class="campo">

                <label for="estado">
                    Estado:
                </label>

                <select
                    id="estado"
                    name="estado"
                    required
                >

                    <option value="DISPONIBLE">
                        DISPONIBLE
                    </option>

                    <option value="NO DISPONIBLE">
                        NO DISPONIBLE
                    </option>

                </select>

            </div>


            <div class="campo">

                <label for="observaciones">
                    Observaciones:
                </label>

                <textarea
                    id="observaciones"
                    name="observaciones"
                    rows="3"
                ></textarea>

            </div>


            <button
                type="submit"
                class="boton"
            >
                + Agregar fecha
            </button>


        </form>

    </div>


    <!-- ==================================================
         LISTADO DE FECHAS
         ================================================== -->

    <h2>Fechas cargadas</h2>


    <?php if ($resultado->num_rows == 0): ?>


        <div class="sin-fechas">

            <p>
                No hay fechas cargadas todavía.
            </p>

        </div>


    <?php else: ?>


        <?php while ($fecha = $resultado->fetch_assoc()): ?>


            <div class="fecha">


                <!-- FECHA -->

                <h3>

                    <?php

                    echo date(
                        'd/m/Y',
                        strtotime($fecha['fecha'])
                    );

                    ?>

                </h3>


                <!-- HORARIO -->

                <div class="dato">

                    <strong>
                        Horario:
                    </strong>


                    <?php

                    echo date(
                        'H:i',
                        strtotime($fecha['hora_inicio'])
                    );

                    ?>


                    -


                    <?php

                    echo date(
                        'H:i',
                        strtotime($fecha['hora_fin'])
                    );

                    ?>

                </div>


                <!-- ESTADO -->

                <div class="dato">

                    <strong>
                        Estado:
                    </strong>


                    <?php if ($fecha['estado'] == 'DISPONIBLE'): ?>


                        <span class="estado disponible">

                            DISPONIBLE

                        </span>


                    <?php else: ?>


                        <span class="estado no-disponible">

                            NO DISPONIBLE

                        </span>


                    <?php endif; ?>


                </div>


                <!-- OBSERVACIONES -->

                <?php if (!empty($fecha['observaciones'])): ?>


                    <div class="dato">

                        <strong>
                            Observaciones:
                        </strong>


                        <?php

                        echo htmlspecialchars(
                            $fecha['observaciones']
                        );

                        ?>

                    </div>


                <?php endif; ?>


                <!-- ==================================================
                     BOTONES
                     ================================================== -->

                <div class="botones">


                    <!-- BOTÓN EDITAR -->

                    <button
                        type="button"
                        class="boton-editar"
                        onclick="mostrarFormulario(<?php echo $fecha['id_disponibilidad']; ?>)"
                    >
                        ✏️ Editar
                    </button>


                    <!-- BOTÓN ELIMINAR -->

                    <form
                        action="admin_disponibilidad.php"
                        method="POST"
                        style="display: inline;"
                        onsubmit="return confirm('¿Seguro que querés eliminar esta fecha?');"
                    >


                        <input
                            type="hidden"
                            name="accion"
                            value="eliminar"
                        >


                        <input
                            type="hidden"
                            name="id_disponibilidad"
                            value="<?php echo $fecha['id_disponibilidad']; ?>"
                        >


                        <button
                            type="submit"
                            class="boton-eliminar"
                        >
                            🗑️ Eliminar
                        </button>


                    </form>


                </div>


                <!-- ==================================================
                     FORMULARIO DE EDICIÓN
                     ================================================== -->

                <div
                    id="editar-<?php echo $fecha['id_disponibilidad']; ?>"
                    class="formulario-edicion"
                >


                    <h3>
                        Editar fecha
                    </h3>


                    <form
                        action="admin_disponibilidad.php"
                        method="POST"
                    >


                        <input
                            type="hidden"
                            name="accion"
                            value="editar"
                        >


                        <input
                            type="hidden"
                            name="id_disponibilidad"
                            value="<?php echo $fecha['id_disponibilidad']; ?>"
                        >


                        <!-- FECHA -->

                        <div class="campo">

                            <label>
                                Fecha:
                            </label>

                            <input
                                type="date"
                                name="fecha"
                                value="<?php echo $fecha['fecha']; ?>"
                                required
                            >

                        </div>


                        <!-- HORA INICIO -->

                        <div class="campo">

                            <label>
                                Hora de inicio:
                            </label>

                            <input
                                type="time"
                                name="hora_inicio"
                                value="<?php echo date('H:i', strtotime($fecha['hora_inicio'])); ?>"
                                required
                            >

                        </div>


                        <!-- HORA FIN -->

                        <div class="campo">

                            <label>
                                Hora de finalización:
                            </label>

                            <input
                                type="time"
                                name="hora_fin"
                                value="<?php echo date('H:i', strtotime($fecha['hora_fin'])); ?>"
                                required
                            >

                        </div>


                        <!-- ESTADO -->

                        <div class="campo">

                            <label>
                                Estado:
                            </label>

                            <select
                                name="estado"
                                required
                            >


                                <option
                                    value="DISPONIBLE"
                                    <?php
                                    if ($fecha['estado'] == 'DISPONIBLE') {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    DISPONIBLE
                                </option>


                                <option
                                    value="NO DISPONIBLE"
                                    <?php
                                    if ($fecha['estado'] == 'NO DISPONIBLE') {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    NO DISPONIBLE
                                </option>


                            </select>

                        </div>


                        <!-- OBSERVACIONES -->

                        <div class="campo">

                            <label>
                                Observaciones:
                            </label>


                            <textarea
                                name="observaciones"
                                rows="3"
                            ><?php

                            echo htmlspecialchars(
                                $fecha['observaciones'] ?? ''
                            );

                            ?></textarea>


                        </div>


                        <!-- GUARDAR -->

                        <button
                            type="submit"
                            class="boton-guardar"
                        >
                            💾 Guardar cambios
                        </button>


                    </form>


                </div>


            </div>


        <?php endwhile; ?>


    <?php endif; ?>


</div>


<!-- ======================================================
     JAVASCRIPT PARA MOSTRAR/OCULTAR EDICIÓN
     ====================================================== -->

<script>

function mostrarFormulario(id) {

    const formulario = document.getElementById("editar-" + id);


    if (formulario.style.display === "none" || formulario.style.display === "") {

        formulario.style.display = "block";

    } else {

        formulario.style.display = "none";

    }

}

</script>


</body>

</html>
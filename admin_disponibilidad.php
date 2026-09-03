<?php

include("conexion.php");

// Obtener todas las fechas
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

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Administrar disponibilidad</h1>


    <!-- FORMULARIO PARA AGREGAR UNA FECHA -->

    <div class="formulario">

        <h2>Agregar nueva fecha</h2>

        <form action="guardar_disponibilidad.php" method="POST">

            <div class="campo">

                <label for="fecha">Fecha:</label>

                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    required
                >

            </div>


            <div class="campo">

                <label for="hora_inicio">Hora de inicio:</label>

                <input
                    type="time"
                    id="hora_inicio"
                    name="hora_inicio"
                    required
                >

            </div>


            <div class="campo">

                <label for="hora_fin">Hora de finalización:</label>

                <input
                    type="time"
                    id="hora_fin"
                    name="hora_fin"
                    required
                >

            </div>


            <div class="campo">

                <label for="estado">Estado:</label>

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


    <!-- LISTADO DE FECHAS -->

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

                <h3>
                    <?php
                    echo date(
                        'd/m/Y',
                        strtotime($fecha['fecha'])
                    );
                    ?>
                </h3>


                <div class="dato">

                    <strong>Horario:</strong>

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


                <div class="dato">

                    <strong>Estado:</strong>

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


                <?php if (!empty($fecha['observaciones'])): ?>

                    <div class="dato">

                        <strong>Observaciones:</strong>

                        <?php
                        echo htmlspecialchars(
                            $fecha['observaciones']
                        );
                        ?>

                    </div>

                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

</body>

</html>

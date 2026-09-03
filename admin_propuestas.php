<?php

include("conexion.php");

// Obtener todas las propuestas
$sql = "SELECT 
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
            d.hora_fin

        FROM propuesta p

        INNER JOIN banda_proyecto b
            ON p.id_banda = b.id_banda

        INNER JOIN contacto c
            ON p.id_contacto = c.id_contacto

        INNER JOIN disponibilidad d
            ON p.id_disponibilidad = d.id_disponibilidad

        ORDER BY p.fecha_envio DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al obtener las propuestas: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrar propuestas</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .contenedor {
            max-width: 1200px;
            margin: auto;
        }

        .propuesta {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .propuesta h2 {
            margin-top: 0;
        }

        .dato {
            margin: 8px 0;
        }

        .dato strong {
            display: inline-block;
            min-width: 180px;
        }

        .estado {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
        }

        .pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .aprobada {
            background-color: #d4edda;
            color: #155724;
        }

        .rechazada {
            background-color: #f8d7da;
            color: #721c24;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        .sin-propuestas {
            background-color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }

        a {
            color: #0066cc;
        }

                .acciones {
            margin-top: 20px;
        }

        .boton {
            border: none;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            margin-right: 10px;
        }

        .aceptar {
            background-color: #28a745;
            color: white;
        }

        .rechazar {
            background-color: #dc3545;
            color: white;
        }

        .boton:hover {
            opacity: 0.85;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Propuestas recibidas</h1>

    <?php if ($resultado->num_rows == 0): ?>

        <div class="sin-propuestas">
            <p>No hay propuestas recibidas todavía.</p>
        </div>

    <?php else: ?>

        <?php while ($propuesta = $resultado->fetch_assoc()): ?>

            <div class="propuesta">

                <h2>
                    <?php echo htmlspecialchars($propuesta['nombre_banda']); ?>
                </h2>

                <div class="dato">
                    <strong>Estado:</strong>

                    <?php

                    $estado = strtoupper($propuesta['estado_propuesta']);

                    if ($estado == 'PENDIENTE') {
                        echo '<span class="estado pendiente">PENDIENTE</span>';
                    } elseif ($estado == 'APROBADA') {
                        echo '<span class="estado aprobada">APROBADA</span>';
                    } elseif ($estado == 'RECHAZADA') {
                        echo '<span class="estado rechazada">RECHAZADA</span>';
                    } else {
                        echo '<span class="estado">' .
                             htmlspecialchars($estado) .
                             '</span>';
                    }

                    ?>

                </div>

                <hr>

                <h3>Fecha del evento</h3>

                <div class="dato">
                    <strong>Fecha:</strong>

                    <?php
                    echo date(
                        'd/m/Y',
                        strtotime($propuesta['fecha'])
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Horario:</strong>

                    <?php
                    echo date(
                        'H:i',
                        strtotime($propuesta['hora_inicio'])
                    );
                    ?>

                    -

                    <?php
                    echo date(
                        'H:i',
                        strtotime($propuesta['hora_fin'])
                    );
                    ?>
                </div>

                <hr>

                <h3>Datos de la banda / proyecto</h3>

                <div class="dato">
                    <strong>Nombre:</strong>

                    <?php
                    echo htmlspecialchars(
                        $propuesta['nombre_banda']
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Género / estilo:</strong>

                    <?php
                    echo htmlspecialchars(
                        $propuesta['genero_estilo']
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Descripción:</strong>

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $propuesta['descripcion_banda']
                        )
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Redes sociales:</strong>

                    <?php if (!empty($propuesta['redes_sociales'])): ?>

                        <?php
                        echo htmlspecialchars(
                            $propuesta['redes_sociales']
                        );
                        ?>

                    <?php else: ?>

                        No especificadas

                    <?php endif; ?>

                </div>

                <div class="dato">
                    <strong>Link música:</strong>

                    <a
                        href="<?php echo htmlspecialchars($propuesta['link_musica']); ?>"
                        target="_blank"
                    >
                        Escuchar música
                    </a>
                </div>

                <?php if (!empty($propuesta['link_presentacion'])): ?>

                    <div class="dato">
                        <strong>Presentación en vivo:</strong>

                        <a
                            href="<?php echo htmlspecialchars($propuesta['link_presentacion']); ?>"
                            target="_blank"
                        >
                            Ver presentación
                        </a>
                    </div>

                <?php endif; ?>

                <hr>

                <h3>Datos de contacto</h3>

                <div class="dato">
                    <strong>Nombre:</strong>

                    <?php
                    echo htmlspecialchars(
                        $propuesta['nombre_contacto']
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Email:</strong>

                    <?php
                    echo htmlspecialchars(
                        $propuesta['email']
                    );
                    ?>
                </div>

                <div class="dato">
                    <strong>Teléfono / WhatsApp:</strong>

                    <?php
                    echo htmlspecialchars(
                        $propuesta['telefono_whatsapp']
                    );
                    ?>
                </div>

                <hr>

                <h3>Propuesta</h3>

                <div class="dato">
                    <strong>Descripción:</strong>

                    <p>
                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                $propuesta['descripcion_propuesta']
                            )
                        );
                        ?>
                    </p>
                </div>

                <div class="dato">
                    <strong>Rider técnico:</strong>

                    <p>
                        <?php

                        if (!empty($propuesta['rider_tecnico'])) {

                            echo nl2br(
                                htmlspecialchars(
                                    $propuesta['rider_tecnico']
                                )
                            );

                        } else {

                            echo "No especificado";

                        }

                        ?>
                    </p>
                </div>

                <hr>

                                <div class="dato">

                    <strong>Fecha de envío:</strong>

                    <?php
                    echo date(
                        'd/m/Y H:i',
                        strtotime($propuesta['fecha_envio'])
                    );
                    ?>

                </div>


                <?php if ($estado == 'PENDIENTE'): ?>

                    <hr>

                    <div class="acciones">

                        <form
                            action="gestionar_propuesta.php"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('¿Seguro que querés aceptar esta propuesta?');"
                        >

                            <input
                                type="hidden"
                                name="id_propuesta"
                                value="<?php echo $propuesta['id_propuesta']; ?>"
                            >

                            <input
                                type="hidden"
                                name="accion"
                                value="aprobar"
                            >

                            <button
                                type="submit"
                                class="boton aceptar"
                            >
                                ✅ Aceptar propuesta
                            </button>

                        </form>


                        <form
                            action="gestionar_propuesta.php"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('¿Seguro que querés rechazar esta propuesta?');"
                        >

                            <input
                                type="hidden"
                                name="id_propuesta"
                                value="<?php echo $propuesta['id_propuesta']; ?>"
                            >

                            <input
                                type="hidden"
                                name="accion"
                                value="rechazar"
                            >

                            <button
                                type="submit"
                                class="boton rechazar"
                            >
                                ❌ Rechazar propuesta
                            </button>

                        </form>

                    </div>

                <?php endif; ?>


            </div>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

</body>

</html>
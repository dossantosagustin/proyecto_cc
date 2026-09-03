<?php

require_once("proteccion_admin.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel de administración</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .contenedor {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 35px;
        }

        .opciones {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .opcion {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-decoration: none;
            color: #222;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .opcion:hover {
            transform: translateY(-3px);
        }

        .icono {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .opcion h2 {
            margin: 0 0 10px 0;
        }

        .opcion p {
            color: #666;
            margin: 0;
            line-height: 1.5;
        }

        @media (max-width: 700px) {

            .opciones {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Panel de administración</h1>

    <p class="subtitulo">
        Administración del Centro Cultural
    </p>

    <div style="text-align: center; margin-bottom: 30px;">

        <a
            href="logout.php"
            style="
                display: inline-block;
                padding: 10px 20px;
                background-color: #dc3545;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            "
        >
            Cerrar sesión
        </a>

    </div>


    <div class="opciones">


        <!-- PROPUESTAS -->

        <a
            href="admin_propuestas.php"
            class="opcion"
        >

            <div class="icono">
                📋
            </div>

            <h2>
                Propuestas recibidas
            </h2>

            <p>
                Ver las propuestas enviadas por las bandas,
                aceptar o rechazar propuestas.
            </p>

        </a>


        <!-- DISPONIBILIDAD -->

        <a
            href="admin_disponibilidad.php"
            class="opcion"
        >

            <div class="icono">
                📅
            </div>

            <h2>
                Administrar disponibilidad
            </h2>

            <p>
                Agregar y consultar las fechas disponibles
                del Centro Cultural.
            </p>

        </a>


        <!-- EVENTOS PROGRAMADOS -->

        <a
            href="admin_eventos.php"
            class="opcion"
        >

            <div class="icono">
                🎵
            </div>

            <h2>
                Eventos programados
            </h2>

            <p>
                Consultar el calendario de eventos
                programados en el Centro Cultural.
            </p>

        </a>


        <!-- PÁGINA PRINCIPAL -->

        <a
            href="index.php"
            class="opcion"
        >

            <div class="icono">
                🏠
            </div>

            <h2>
                Página principal
            </h2>

            <p>
                Volver a la página principal del Centro Cultural.
            </p>

        </a>


    </div>

</div>

</body>

</html>
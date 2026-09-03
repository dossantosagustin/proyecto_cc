<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Centro Cultural</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            max-width: 900px;
            margin: auto;
            padding: 60px 20px;
            text-align: center;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .descripcion {
            font-size: 18px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .boton {
            display: inline-block;
            padding: 15px 30px;
            background-color: #222;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
            transition: background-color 0.2s;
        }

        .boton:hover {
            background-color: #444;
        }

        .seccion {
            background-color: white;
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .seccion h2 {
            margin-top: 0;
        }

        .seccion p {
            color: #666;
            line-height: 1.5;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>
        Centro Cultural
    </h1>

    <p class="descripcion">
        Espacio para recibir propuestas de bandas y proyectos
        musicales interesados en realizar actividades y presentaciones
        en el Centro Cultural.
    </p>


    <a
        href="calendario.php"
        class="boton"
    >
        Consultar fechas disponibles
    </a>


    <div class="seccion">

        <h2>
            ¿Querés presentar una propuesta?
        </h2>

        <p>
            Consultá primero el calendario para conocer las fechas
            disponibles. Luego seleccioná una fecha y completá el
            formulario con los datos de tu proyecto y la propuesta
            que te gustaría realizar.
        </p>

    </div>

</div>

</body>

</html>
<?php

require_once "conexion.php";

echo "Conexión exitosa";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Cultural - Enviar propuesta</title>
</head>

<body>

    <h1>Enviar propuesta</h1>

    <form action="" method="POST">

        <!-- DATOS DEL PROYECTO -->
        <h2>Datos del proyecto</h2>

        <label for="nombre">Nombre de la banda o proyecto:</label>
        <input type="text" id="nombre" name="nombre" maxlength="150" required>

        <br><br>

        <label for="genero_estilo">Género o estilo musical:</label>
        <input type="text" id="genero_estilo" name="genero_estilo" maxlength="100" required>

        <br><br>

        <label for="descripcion">Descripción del proyecto:</label>
        <br>
        <textarea id="descripcion" name="descripcion" rows="5" cols="50" required></textarea>

        <br><br>

        <label for="redes_sociales">Redes sociales:</label>
        <input type="text" id="redes_sociales" name="redes_sociales" maxlength="255">

        <br><br>

        <label for="link_musica">Link de música:</label>
        <input type="url" id="link_musica" name="link_musica" maxlength="500" required>

        <br><br>

        <label for="link_presentacion">Link de presentación:</label>
        <input type="url" id="link_presentacion" name="link_presentacion" maxlength="500">

        <!-- DATOS DE CONTACTO -->
        <h2>Datos de contacto</h2>

        <label for="nombre_contacto">Nombre y apellido:</label>
        <input type="text" id="nombre_contacto" name="nombre_contacto" maxlength="150" required>

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" maxlength="150" required>

        <br><br>

        <label for="telefono_whatsapp">Teléfono / WhatsApp:</label>
        <input type="tel" id="telefono_whatsapp" name="telefono_whatsapp" maxlength="50" required>

        <!-- DISPONIBILIDAD DEL CENTRO CULTURAL -->
        <h2>Fecha y horario</h2>

        <p>
            Seleccioná una fecha y horario disponibles en el centro cultural.
        </p>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>

        <br><br>

        <label for="hora_inicio">Hora de inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required>

        <br><br>

        <label for="hora_fin">Hora de finalización:</label>
        <input type="time" id="hora_fin" name="hora_fin" required>

        <br><br>

        <p id="mensaje-disponibilidad"></p>

        <label for="observaciones">Observaciones:</label>
        <br>
        <textarea id="observaciones" name="observaciones" rows="4" cols="50"></textarea>

        <!-- PROPUESTA -->
        <h2>Propuesta</h2>

        <label for="descripcion_propuesta">
            Descripción de la propuesta:
        </label>
        <br>
        <textarea
            id="descripcion_propuesta"
            name="descripcion_propuesta"
            rows="6"
            cols="50"
            required
        ></textarea>

        <br><br>

        <label for="rider_tecnico">Rider técnico:</label>
        <input
            type="text"
            id="rider_tecnico"
            name="rider_tecnico"
            maxlength="500"
        >

        <br><br>

        <button type="submit">Enviar propuesta</button>

    </form>

</body>
</html>
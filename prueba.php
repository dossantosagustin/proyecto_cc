<?php

include "conexion.php";

$sql = "SHOW TABLES";
$resultado = $conexion->query($sql);

if ($resultado) {
    echo "<h2>Tablas de la base de datos:</h2>";

    while ($fila = $resultado->fetch_array()) {
        echo $fila[0] . "<br>";
    }
} else {
    echo "Error: " . $conexion->error;
}

?>
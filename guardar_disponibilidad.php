<?php

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido.");
}

$fecha = $_POST['fecha'] ?? '';
$hora_inicio = $_POST['hora_inicio'] ?? '';
$hora_fin = $_POST['hora_fin'] ?? '';
$estado = $_POST['estado'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';


if (
    empty($fecha) ||
    empty($hora_inicio) ||
    empty($hora_fin) ||
    empty($estado)
) {
    die("Faltan datos obligatorios.");
}


// Verificar que la hora de inicio sea anterior a la hora de fin

if ($hora_inicio >= $hora_fin) {
    die("La hora de inicio debe ser anterior a la hora de finalización.");
}


// Verificar que no exista ya la misma fecha y horario

$sql = "
    SELECT id_disponibilidad
    FROM disponibilidad
    WHERE fecha = ?
    AND hora_inicio = ?
    AND hora_fin = ?
";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sss",
    $fecha,
    $hora_inicio,
    $hora_fin
);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    die(
        "Ya existe una disponibilidad cargada para esa fecha y horario."
    );

}


// Insertar la nueva disponibilidad

$sql = "
    INSERT INTO disponibilidad
    (
        fecha,
        hora_inicio,
        hora_fin,
        estado,
        observaciones
    )
    VALUES (?, ?, ?, ?, ?)
";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sssss",
    $fecha,
    $hora_inicio,
    $hora_fin,
    $estado,
    $observaciones
);

if ($stmt->execute()) {

    header(
        "Location: admin_disponibilidad.php?mensaje=guardada"
    );

    exit;

} else {

    die(
        "Error al guardar la disponibilidad: " .
        $conexion->error
    );

}

?>
<?php

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido.");
}

$id_propuesta = isset($_POST['id_propuesta']) ? intval($_POST['id_propuesta']) : 0;
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

if ($id_propuesta <= 0) {
    die("Propuesta inválida.");
}

if ($accion !== 'aprobar' && $accion !== 'rechazar') {
    die("Acción inválida.");
}

try {

    $conexion->begin_transaction();

    // Buscamos la propuesta y la disponibilidad relacionada
    $sql = "
        SELECT 
            p.id_propuesta,
            p.estado AS estado_propuesta,
            p.id_disponibilidad,
            d.estado AS estado_disponibilidad
        FROM propuesta p
        INNER JOIN disponibilidad d 
            ON p.id_disponibilidad = d.id_disponibilidad
        WHERE p.id_propuesta = ?
        FOR UPDATE
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_propuesta);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        throw new Exception("La propuesta no existe.");
    }

    $propuesta = $resultado->fetch_assoc();

    // =========================
    // APROBAR
    // =========================
    if ($accion === 'aprobar') {

        // Verificamos que todavía esté disponible
        if ($propuesta['estado_disponibilidad'] !== 'DISPONIBLE') {
            throw new Exception(
                "No se puede aprobar esta propuesta porque la fecha ya no está disponible."
            );
        }

        // Cambiar propuesta a APROBADA
        $sql = "
            UPDATE propuesta
            SET estado = 'APROBADA'
            WHERE id_propuesta = ?
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_propuesta);
        $stmt->execute();


        // Cambiar disponibilidad a NO DISPONIBLE
        $sql = "
            UPDATE disponibilidad
            SET estado = 'NO DISPONIBLE'
            WHERE id_disponibilidad = ?
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $propuesta['id_disponibilidad']);
        $stmt->execute();


        // Crear evento
        $sql = "
            INSERT INTO evento (id_propuesta, estado)
            VALUES (?, 'PROGRAMADO')
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_propuesta);
        $stmt->execute();

        $conexion->commit();

        header("Location: admin_propuestas.php?mensaje=aprobada");
        exit;
    }


    // =========================
    // RECHAZAR
    // =========================
    if ($accion === 'rechazar') {

        $sql = "
            UPDATE propuesta
            SET estado = 'RECHAZADA'
            WHERE id_propuesta = ?
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_propuesta);
        $stmt->execute();

        // La disponibilidad NO cambia.
        // La fecha sigue disponible para otras propuestas.

        $conexion->commit();

        header("Location: admin_propuestas.php?mensaje=rechazada");
        exit;
    }

} catch (Exception $e) {

    $conexion->rollback();

    echo "<h2>Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="admin_propuestas.php">Volver a propuestas</a></p>';
}
?>
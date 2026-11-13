<?php
require_once "bd.php";
requerir_login();

$id = $_GET['id'] ?? 0;
$token = $_GET['csrf'] ?? '';

verificar_token_csrf($token);

if ($id > 0) {
    $conexion = conectarBD();

    try {
        // 1. Iniciar la transacción
        $conexion->beginTransaction();

        // 2. Realizar el borrado del registro principal
        $sqlDelete = "DELETE FROM clientes WHERE id = :id";
        $sentenciaDel = $conexion->prepare($sqlDelete);
        $sentenciaDel->bindValue(':id', $id, PDO::PARAM_INT);
        $sentenciaDel->execute();

        // 3. Registrar el evento en la tabla auditoria
        $sqlAudit = "INSERT INTO auditoria (detalle) VALUES (:detalle)";
        $sentenciaAud = $conexion->prepare($sqlAudit);
        $detalle = "Se eliminó el cliente con ID: " . $id;
        $sentenciaAud->bindValue(':detalle', $detalle, PDO::PARAM_STR);
        $sentenciaAud->execute();

        // --- SIMULACIÓN DE FALLO (Descomentar para probar el Rollback) ---
        // throw new Exception("Error forzado para probar rollback.");

        // 4. Confirmar cambios si todo ha ido bien
        $conexion->commit();

    } catch (Exception $e) {
        // En caso de cualquier error, deshacer todas las operaciones
        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }
        die("Error durante la transacción de borrado. Operación cancelada: " . $e->getMessage());
    }
}

header("Location: listar.php");
exit();
?>
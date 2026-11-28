<?php
require_once "bd.php";
requerir_login();

$id = $_GET['id'] ?? 0;
$conexion = conectarBD();

$sql = "SELECT * FROM clientes WHERE id = :id";
$sentencia = $conexion->prepare($sql);
$sentencia->bindValue(':id', $id, PDO::PARAM_INT);
$sentencia->execute();
$cliente = $sentencia->fetch();

if (!$cliente) {
    die("Cliente no encontrado.");
}
?>

<h2>Detalle del Cliente #<?php echo e($cliente->id); ?></h2>
<p><strong>Nombre:</strong> <?php echo e($cliente->nombre); ?></p>
<p><strong>Email:</strong> <?php echo e($cliente->email); ?></p>
<p><strong>Observaciones:</strong> <?php echo e($cliente->observaciones); ?></p>

<p><a href="listar.php">Volver al listado</a></p>
</body>
</html>
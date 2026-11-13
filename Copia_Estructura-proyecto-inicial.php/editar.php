<?php
require_once "bd.php";
requerir_login();

$conexion = conectarBD();
$id = $_GET['id'] ?? ($_POST['id'] ?? 0);
$errores = [];

// Cargar datos actuales
$sql = "SELECT * FROM clientes WHERE id = :id";
$sentencia = $conexion->prepare($sql);
$sentencia->bindValue(':id', $id, PDO::PARAM_INT);
$sentencia->execute();
$cliente = $sentencia->fetch();

if (!$cliente) {
    die("Cliente no encontrado.");
}

// Inicializar variables con datos existentes de la BD
$nombre = $cliente->nombre;
$email = $cliente->email;
$observaciones = $cliente->observaciones;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_token_csrf($_POST['csrf'] ?? '');

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $observaciones = trim($_POST['observaciones'] ?? '');

    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Debe ser un email válido.";

    if (empty($errores)) {
        $sqlUpd = "UPDATE clientes SET nombre = :nombre, email = :email, observaciones = :observaciones WHERE id = :id";
        $sentenciaUpd = $conexion->prepare($sqlUpd);
        $sentenciaUpd->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $sentenciaUpd->bindValue(':email', $email, PDO::PARAM_STR);
        $sentenciaUpd->bindValue(':observaciones', $observaciones, PDO::PARAM_STR);
        $sentenciaUpd->bindValue(':id', $id, PDO::PARAM_INT);
        $sentenciaUpd->execute();

        header("Location: listar.php");
        exit();
    }
}
?>

<h2>Editar Cliente #<?php echo e($id); ?></h2>

<?php if (!empty($errores)): ?>
    <ul class="error">
        <?php foreach ($errores as $err): ?>
            <li><?php echo e($err); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="editar.php">
    <input type="hidden" name="csrf" value="<?php echo generar_token_csrf(); ?>">
    <input type="hidden" name="id" value="<?php echo e($id); ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo e($nombre); ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo e($email); ?>"><br><br>

    <label>Observaciones:</label><br>
    <textarea name="observaciones"><?php echo e($observaciones); ?></textarea><br><br>

    <button type="submit">Guardar Cambios</button>
</form>

<p><a href="listar.php">Cancelar</a></p>
</body>
</html>
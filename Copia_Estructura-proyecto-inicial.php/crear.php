<?php
require_once "bd.php";
requerir_login();

$errores = [];
$nombre = "";
$email = "";
$observaciones = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Verificar CSRF
    verificar_token_csrf($_POST['csrf'] ?? '');

    // 2. Recoger y sanitizar datos de entrada
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $observaciones = trim($_POST['observaciones'] ?? '');

    // 3. Validación en el servidor
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Debe proporcionar un email válido.";
    }

    // 4. Si no hay errores, insertar en BD y redirigir (Patrón PRG)
    if (empty($errores)) {
        $conexion = conectarBD();
        $sql = "INSERT INTO clientes (nombre, email, observaciones) VALUES (:nombre, :email, :observaciones)";
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $sentencia->bindValue(':email', $email, PDO::PARAM_STR);
        $sentencia->bindValue(':observaciones', $observaciones, PDO::PARAM_STR);
        $sentencia->execute();

        header("Location: listar.php");
        exit();
    }
}
?>

<h2>Añadir Nuevo Cliente</h2>

<?php if (!empty($errores)): ?>
    <ul class="error">
        <?php foreach ($errores as $err): ?>
            <li><?php echo e($err); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="crear.php">
    <input type="hidden" name="csrf" value="<?php echo generar_token_csrf(); ?>">

    <label>Nombre (*):</label><br>
    <input type="text" name="nombre" value="<?php echo e($nombre); ?>"><br><br>

    <label>Email (*):</label><br>
    <input type="email" name="email" value="<?php echo e($email); ?>"><br><br>

    <label>Observaciones:</label><br>
    <textarea name="observaciones"><?php echo e($observaciones); ?></textarea><br><br>

    <button type="submit">Guardar Cliente</button>
</form>

<p><a href="listar.php">Cancelar y volver</a></p>
</body>
</html>
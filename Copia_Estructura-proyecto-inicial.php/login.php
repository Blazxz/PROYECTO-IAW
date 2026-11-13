<?php
require_once "bd.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($usuario) && !empty($password)) {
        $conexion = conectarBD();
        
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $sentencia->execute();
        $userObj = $sentencia->fetch();

        // Verificación segura de contraseña con hash
        if ($userObj && password_verify($password, $userObj->password)) {
            $_SESSION['usuario'] = $userObj->usuario;
            header("Location: listar.php");
            exit();
        } else {
            $error = "Credenciales incorrectas.";
        }
    } else {
        $error = "Por favor, rellena todos los campos.";
    }
}
?>

<h2>Inicio de Sesión</h2>

<?php if (!empty($error)): ?>
    <p class="error"><?php echo e($error); ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" value="<?php echo e($_POST['usuario'] ?? ''); ?>" required><br><br>
    
    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>
    
    <button type="submit">Entrar</button>
</form>
</body>
</html>
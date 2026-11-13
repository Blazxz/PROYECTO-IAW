<?php
require_once "bd.php";
requerir_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_token_csrf($_POST['csrf'] ?? '');
    
    $nuevo_tema = $_POST['tema'] ?? 'claro';
    setcookie('preferencia_tema', $nuevo_tema, time() + (86400 * 30), "/"); // Validez de 30 días
    
    header("Location: listar.php");
    exit();
}
?>

<h2>Preferencia de Tema</h2>
<form method="POST" action="preferencia.php">
    <input type="hidden" name="csrf" value="<?php echo generar_token_csrf(); ?>">
    <label>Selecciona el tema:</label>
    <select name="tema">
        <option value="claro" <?php echo ($tema_color === 'claro') ? 'selected' : ''; ?>>Claro</option>
        <option value="oscuro" <?php echo ($tema_color === 'oscuro') ? 'selected' : ''; ?>>Oscuro</option>
    </select>
    <button type="submit">Guardar Preferencia</button>
</form>
<p><a href="listar.php">Volver al listado</a></p>
</body>
</html>
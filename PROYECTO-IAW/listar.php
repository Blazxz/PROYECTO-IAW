<?php
require_once "bd.php";
requerir_login(); // Protección de ruta

$conexion = conectarBD();

// Búsqueda simple
$buscar = trim($_GET['buscar'] ?? '');

// Paginación básica
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$limite = 2; // Pocos registros para probar la paginación en el ejemplo básico
$offset = ($pagina - 1) * $limite;

// Consulta con filtro preparado
$sql = "SELECT * FROM clientes WHERE nombre LIKE :buscar LIMIT :limite OFFSET :offset";
$sentencia = $conexion->prepare($sql);
$sentencia->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
$sentencia->bindValue(':limite', $limite, PDO::PARAM_INT);
$sentencia->bindValue(':offset', $offset, PDO::PARAM_INT);
$sentencia->execute();
$clientes = $sentencia->fetchAll();

// Total registros para paginar
$sqlTotal = "SELECT COUNT(*) FROM clientes WHERE nombre LIKE :buscar";
$sentenciaTotal = $conexion->prepare($sqlTotal);
$sentenciaTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
$sentenciaTotal->execute();
$totalRegistros = $sentenciaTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);
?>

<h2>Panel de Gestión - Clientes</h2>
<p>Bienvenido, <strong><?php echo e($_SESSION['usuario']); ?></strong> | 
   <a href="preferencia.php">Cambiar Tema</a> | 
   <a href="logout.php">Cerrar Sesión</a>
</p>

<form method="GET" action="listar.php">
    <input type="text" name="buscar" placeholder="Buscar por nombre..." value="<?php echo e($buscar); ?>">
    <button type="submit">Buscar</button>
</form>

<p><a href="crear.php">➕ Añadir Nuevo Cliente</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($clientes as $c): ?>
    <tr>
        <td><?php echo e($c->id); ?></td>
        <td><?php echo e($c->nombre); ?></td>
        <td><?php echo e($c->email); ?></td>
        <td>
            <a href="ver.php?id=<?php echo e($c->id); ?>">Ver</a> | 
            <a href="editar.php?id=<?php echo e($c->id); ?>">Editar</a> | 
            <a href="borrar.php?id=<?php echo e($c->id); ?>&csrf=<?php echo generar_token_csrf(); ?>" onclick="return confirm('¿Seguro?')">Borrar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Paginador Básico -->
<div style="margin-top: 15px;">
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="listar.php?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($buscar); ?>" 
           style="<?php echo ($i === $pagina) ? 'font-weight:bold;' : ''; ?>">
           [<?php echo $i; ?>]
        </a>
    <?php endfor; ?>
</div>

</body>
</html>
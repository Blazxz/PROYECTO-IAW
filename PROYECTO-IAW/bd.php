<?php
// Iniciar sesión en todas las páginas que incluyan este archivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Conexión PDO a la Base de Datos
function conectarBD() {
    $host = 'localhost';
    $db   = 'mini_proyecto';
    $user = 'root';
    $pass = 'Admin2627'; // Adaptar contraseña de MySQL según entorno
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    try {
        return new PDO($dsn, $user, $pass, $opciones);
    } catch (PDOException $e) {
        die("Error de conexión a la BD: " . $e->getMessage());
    }
}

// 2. Control de Sesión (Rutas protegidas)
function requerir_login() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }
}

// 3. Función de Escapado XSS
function e($cadena) {
    return htmlspecialchars($cadena ?? '', ENT_QUOTES, 'UTF-8');
}

// 4. Funciones de Protección CSRF
function generar_token_csrf() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verificar_token_csrf($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Error de seguridad: Token CSRF no válido.");
    }
}

// 5. Preferencia mediante Cookie (Tema de color simple)
$tema_color = $_COOKIE['preferencia_tema'] ?? 'claro';
$bg_color = ($tema_color === 'oscuro') ? '#333333' : '#ffffff';
$text_color = ($tema_color === 'oscuro') ? '#ffffff' : '#000000';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { background-color: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>; font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
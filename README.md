<div>
<p>
<img src="Pictures/Portada/logo_github.png" width="50">
<img src="Pictures/Portada/Logo-PHP.png" width="50">
<img src="Pictures/Portada/Logo-MySQL.png" width="50">
<img src="Pictures/Portada/Logo-HTML.png" width="44">
<img src="Pictures/Portada/Logo-CSS.png" width="50">
<img src="Pictures/Portada/Logo-Linux.png" width="60">
<img src="Pictures/Portada/Logo-Windows.png" width="50">
</p> 
</div>

<div>
# PROYECTO-IAW
Mini-Proyecto PHP + PDO + Seguridad

# Enunciado del ejercicio

A continuación, se mencionará el objetivo general y la temática que deberá cumplir el proyecto denominado PROYECTO-IAW.

## Objetivo General
Desarrollar una pequeña aplicación web funcional en PHP puro (sin frameworks) que
interactúe con una base de datos MySQL/MariaDB utilizando PDO. La aplicación debe
implementar un ciclo CRUD completo, gestión de usuarios mediante sesiones, control de
preferencias con cookies y medidas básicas de seguridad web (inmunidad a inyección SQL,
XSS y CSRF).

## Temáticas a elegir

Los alumnos (individualmente o en parejas) deberán elegir una de las siguientes temáticas:

1. Gestor de Incidencias (Helpdesk): Registro, seguimiento y borrado de tickets
técnicos (título, descripción, prioridad, estado...).

3. Gestor de Inventario / Clientes: Registro, consulta, modificación y borrado de
productos o clientes (nombre, email, categoría, observaciones...).

</div>

<div>
# Objetivos a realizar en este proyecto

Posteriormente, se mencionarán los objetivos a realizar en el proyecto mencionado anteriormente.

### 1. Autenticación y Control de Acceso (Sesiones)

● Login de Usuarios: Pantalla login.php que verifique las credenciales contra la BD.
Las contraseñas deben estar encriptadas usando password_hash() y verificadas
con password_verify().

● Rutas Protegidas: Todas las páginas privadas (listar.php, crear.php,
editar.php, borrar.php, ver.php, preferencia.php) deben comprobar si
existe la sesión mediante session_start() y una función auxiliar
(requerir_login()). Si el usuario no ha iniciado sesión, debe redirigir
inmediatamente a login.php.

● Cierre de sesión: logout.php debe destruir la sesión completamente y eliminar la
cookie de sesión del navegador.

### 2. Base de Datos y PDO (Acceso Seguro)

● Conexión centralizada: bd.php debe crear y retornar la conexión PDO configurando
el DSN en UTF-8 (utf8mb4), el modo de errores por excepciones
(PDO::ERRMODE_EXCEPTION) y la devolución de datos por defecto
(PDO::FETCH_OBJ).

● Inmunidad a Inyección SQL: Está prohibido concatenar datos del usuario dentro
de las consultas SQL. Todas las consultas con parámetros variables (SELECT,
INSERT, UPDATE, DELETE) deben utilizar sentencias preparadas
($conexion->prepare()) con marcadores (:parametro o ?) y bindValue().

### 3. Seguridad de Entrada y Salida (XSS y CSRF)

● Protección XSS: Ningún dato proveniente de la BD o de $_POST/$_GET se debe pintar
en pantalla directamente sin procesar. Debe crearse y aplicarse en todos los echo una
función de escapado e($cadena) que emplee htmlspecialchars().

● Protección CSRF: Todos los formularios que envíen datos vía POST (crear.php,
editar.php, preferencia.php) y los enlaces destructivos por GET (borrar.php)
deben incluir un token CSRF generado en la sesión y verificado en el servidor mediante
hash_equals().

### 4. Formularios, Validación y Patrón PRG

● Validación en Servidor: Todos los campos obligatorios deben validarse en PHP. Si
falta algún dato o el formato es incorrecto, la página debe mostrar los errores y volver
a rellenar el formulario con los datos previamente introducidos.

● Patrón PRG (Post/Redirect/Get): Tras procesar con éxito un formulario POST, el
script debe redirigir usando header('Location: ...'); exit(); para evitar el
reenvío accidental de datos al refrescar la pantalla.

### 5. Listado: Búsqueda y Paginación

● Buscador: listar.php debe contar con un cajetín de texto que permita filtrar los
registros por nombre/título mediante una sentencia LIKE preparada.

● Paginación: Debe calcularse LIMIT y OFFSET a partir del parámetro
$_GET['pagina'] y mostrar un paginador con enlaces navegables.

### 6. Transacción Segura en el Borrado (borrar.php)

● La eliminación de cualquier registro debe ejecutarse dentro de un bloque
Transaccional con PDO (beginTransaction(), commit(), rollBack()).

● Dentro de la misma transacción, al borrar un registro de la tabla principal se debe
insertar una anotación de auditoría en la tabla auditoria indicando el evento.

● El script debe incluir una línea comentada de prueba para forzar un error/excepción y
demostrar que el rollBack() deshace la eliminación correctamente sin alterar la
base de datos.

### 7. Preferencia Persistente con Cookie

● En preferencia.php, el usuario podrá elegir una preferencia visual (por ejemplo,
tema claro u oscuro).

● Esta preferencia se guardará usando setcookie() y se aplicará dinámicamente en
las páginas de la aplicación leyendo $_COOKIE.
</div>

<?php include_once("conexion.php"); //1. Crear conexión a la Base de Datos
$con = mysqli_connect($host, $usuario, $clave, $bd) or die('Fallo la conexion');
mysqli_set_charset($con, "utf8");
$nombre_usuario = $_GET['nombre_usuario'];
$contrasena = $_GET['contrasena'];

// Utilizamos la función consultar de la clase Conexion para realizar una consulta a la base de datos
$consulta = "SELECT id, nombre_usuario, nombres, apellidos, rol_id FROM $bd.usuarios where nombre_usuario ='$nombre_usuario' AND contrasena ='$contrasena'";
$resultado = mysqli_query($con, $consulta);
while ($fila = mysqli_fetch_array($resultado)) {
    $resultado1[] = $fila;
}
echo json_encode($resultado1, JSON_UNESCAPED_UNICODE);
mysqli_close($con);


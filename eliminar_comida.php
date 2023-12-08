<?php
include_once("conexion.php");

// 1. Crear conexión a la Base de Datos
$con = mysqli_connect($host, $usuario, $clave, $bd) or die('Fallo la conexión');
mysqli_set_charset($con, "utf8");

// 2. Obtener el ID de la comida a eliminar desde la solicitud GET
$idComida = $_GET['id'];

// 3. Eliminar la comida de la tabla
$eliminar = "DELETE FROM $bd.comidas WHERE id = '$idComida'";
$resultadoEliminar = mysqli_query($con, $eliminar);

if ($resultadoEliminar) {
    // Éxito al eliminar la comida
    $response = array('message' => 'La comida se ha eliminado correctamente.');
} else {
    // Error al eliminar la comida
    $response = array('message' => 'Error al eliminar la comida: ' . mysqli_error($con));
}

// 4. Devolver la respuesta en formato JSON
header('Content-Type: application/json');
//echo json_encode($response);
mysqli_close($con);

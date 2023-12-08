<?php
include_once("conexion.php");

// 1. Crear conexión a la Base de Datos
$con = mysqli_connect($host, $usuario, $clave, $bd) or die('Fallo la conexión');
mysqli_set_charset($con, "utf8");

// 2. Obtener los datos del JSON
$data = json_decode(file_get_contents('php://input'), true);

$idComida = $data['id_comida'] ?? "";
$nombre = $data['nombre'] ?? "";
$imagen = $data['imagen'] ?? "";
$descripcion = $data['descripcion'] ?? "";
$precio = $data['precio'] ?? "";
$tipoComidaId = $data['tipo_comida_id'] ?? "";

// 3. Actualizar una nueva comida en la tabla
$insertar = "UPDATE $bd.comidas SET nombre = '$nombre', imagen = '$imagen', descripcion = '$descripcion',
    precio = '$precio', tipo_comida_id = '$tipoComidaId' WHERE id = '$idComida'";
$resultadoInsertar = mysqli_query($con, $insertar);

if ($resultadoInsertar) {
    // Éxito al insertar la nueva comida
    $response = array('message' => 'La comida se ha actualizado correctamente.');
} else {
    // Error al insertar la nueva comida
    $response = array('message' => 'Error al actualizar la comida: ' . mysqli_error($con));
}

// 4. Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);

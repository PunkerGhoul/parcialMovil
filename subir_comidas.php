<?php
include_once("conexion.php");

// 1. Crear conexión a la Base de Datos
$con = mysqli_connect($host, $usuario, $clave, $bd) or die('Fallo la conexión');
mysqli_set_charset($con, "utf8");

// 2. Obtener los datos del JSON
$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['nombre'] ?? "";
$imagen = $data['imagen'] ?? "";
$descripcion = $data['descripcion'] ?? "";
$precio = $data['precio'] ?? "";
$tipoComidaId = $data['tipo_comida_id'] ?? "";

// 3. Insertar una nueva comida en la tabla
$insertar = "INSERT INTO $bd.comidas (nombre, imagen, descripcion, precio, tipo_comida_id) 
             VALUES ('$nombre', '$imagen', '$descripcion', '$precio', '$tipoComidaId')";
$resultadoInsertar = mysqli_query($con, $insertar);

if ($resultadoInsertar) {
    // Éxito al insertar la nueva comida
    $response = array('message' => 'La comida se ha insertado correctamente.');
} else {
    // Error al insertar la nueva comida
    $response = array('message' => 'Error al insertar la comida: ' . mysqli_error($con));
}

// 4. Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);

<?php
include_once("conexion.php"); // 1. Crear conexión a la Base de Datos

// Verificar si se recibió una solicitud POST con datos en formato JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Verificar si se recibieron los datos necesarios
    if (
        isset($data['id']) &&
        isset($data['nombre_usuario']) &&
        isset($data['nombres']) &&
        isset($data['apellidos']) &&
        isset($data['rol_id'])
    ) {
        $id = $data['id'];
        $nombre_usuario = $data['nombre_usuario'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
        $contrasena = $data['contrasena'];
        $rol_id = $data['rol_id'];

        // Establecer la conexión a la base de datos
        $con = mysqli_connect($host, $usuario, $clave, $bd) or die('Fallo la conexión');
        mysqli_set_charset($con, "utf8");

        // Construir la consulta SQL para actualizar el usuario
        $consulta = "UPDATE usuarios SET nombre_usuario = '$nombre_usuario', " .
            "nombres = '$nombres', apellidos = '$apellidos', " .
            "rol_id = '$rol_id' ";

        // Si se proporcionó una contraseña, agregarla a la consulta
        if (!empty($contrasena)) {
            $consulta .= ", contrasena = '$contrasena' ";
        }

        $consulta .= "WHERE id = '$id'";

        // Ejecutar la consulta
        if (mysqli_query($con, $consulta)) {
            // Si la consulta se ejecutó correctamente, se envía una respuesta de éxito
            $response = array('status' => 'success', 'message' => 'Usuario actualizado correctamente');
            echo json_encode($response);
        } else {
            // Si ocurrió un error al ejecutar la consulta, se envía una respuesta de error
            $response = array('status' => 'error', 'message' => 'Error al actualizar el usuario');
            echo json_encode($response);
        }

        mysqli_close($con); // Cerrar la conexión a la base de datos
    } else {
        // Si no se recibieron todos los datos necesarios, se envía una respuesta de error
        $response = array('status' => 'error', 'message' => 'No se proporcionaron todos los datos necesarios');
        echo json_encode($response);
    }
} else {
    // Si no se recibió una solicitud POST, se envía una respuesta de error
    $response = array('status' => 'error', 'message' => 'Método no permitido');
    echo json_encode($response);
}

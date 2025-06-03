<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

// Obtener los datos enviados
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    // Decodificar JSON
    $request = json_decode($postdata);

    // Validar campos
    if (
        trim($request->correo) === '' ||
        trim($request->contrasena) === ''
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Correo y contraseña son obligatorios.']);
        exit();
    }

    // Limpiar datos
    $correo = mysqli_real_escape_string($con, trim($request->correo));
    $contrasena = mysqli_real_escape_string($con, trim($request->contrasena));

    // Buscar usuario
    $sql = "SELECT * FROM usuario WHERE correo = '{$correo}' LIMIT 1";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $usuario = mysqli_fetch_assoc($result);

        if ($contrasena === $usuario['contrasena']) {
            // Inicio de sesión exitoso
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'usuario' => [
                    'id_usuario' => $usuario['Id_usuario'],
                    'nombre'     => $usuario['nombre'],
                    'apellido'   => $usuario['apellido'],
                    'correo'     => $usuario['correo'],
                    'rol'        => $usuario['rol']
                ]
            ]);
        } else {
            // Contraseña incorrecta
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Contraseña incorrecta.']);
        }
    } else {
        // Usuario no encontrado
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Datos no válidos.']);
}

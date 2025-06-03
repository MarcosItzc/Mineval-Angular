<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

// Get the posted data.
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    // Extract the data.
    $request = json_decode($postdata);

    // Validate.
    if (
        trim($request->nombre) === '' ||
        trim($request->apellido) === '' ||
        trim($request->correo) === '' ||
        trim($request->contrasena) === '' ||
        trim($request->rol) === ''
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos los campos son obligatorios.']);
        exit();
    }

    // Sanitize.
    $nombre = mysqli_real_escape_string($con, trim($request->nombre));
    $apellido = mysqli_real_escape_string($con, trim($request->apellido));
    $correo = mysqli_real_escape_string($con, trim($request->correo));
    $contrasena = mysqli_real_escape_string($con, trim($request->contrasena));
    $rol = (int) $request->rol; // Convertir a entero

    // Create.
    $sql = "INSERT INTO `usuario`(`nombre`, `apellido`, `correo`, `contrasena`, `rol`) 
            VALUES ('{$nombre}', '{$apellido}', '{$correo}', '{$contrasena}', {$rol})";

    error_log("SQL: $sql"); // Útil para depuración

    if (mysqli_query($con, $sql)) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'usuario' => [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'rol' => $rol
            ]
        ]);
    } else {
        http_response_code(422);
        error_log("MySQL Error: " . mysqli_error($con));
        echo json_encode(['success' => false, 'error' => 'Error al registrar usuario.']);
    }
}
?>

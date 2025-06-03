<?php
ob_clean(); // 🔄 Limpia cualquier salida anterior
header('Content-Type: application/json; charset=utf-8'); // 📦 Asegura respuesta JSON
error_reporting(0); // (opcional, para ocultar Warnings en producción)

require 'conexion.php';

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);

    if (
        trim($request->materia) === '' ||
        trim($request->institucion) === '' ||
        trim($request->titulo) === '' ||
        trim($request->descripcion) === '' ||
        trim($request->duracion) === ''
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos los campos son obligatorios.']);
        exit();
    }

    $id_profesor = 4; // Puedes cambiarlo luego si viene desde sesión o request
    $materia = mysqli_real_escape_string($con, trim($request->materia));
    $institucion = mysqli_real_escape_string($con, trim($request->institucion));
    $titulo = mysqli_real_escape_string($con, trim($request->titulo));
    $descripcion = mysqli_real_escape_string($con, trim($request->descripcion));
    $duracion = mysqli_real_escape_string($con, trim($request->duracion));

    $sql = "INSERT INTO `examen` (`Id_profesor`, `materia`, `intitucion`, `titulo`, `descripcion`, `duracion`) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssss", $id_profesor, $materia, $institucion, $titulo, $descripcion, $duracion);

        if ($stmt->execute()) {
            $last_id = $stmt->insert_id; // ✅ Asigna el ID insertado correctamente
            echo json_encode(["success" => true, "id_examen" => $last_id]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $con->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió ningún dato.']);
}
?>

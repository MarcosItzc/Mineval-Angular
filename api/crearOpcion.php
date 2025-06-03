<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);

    if (
        !isset($request->id_pregunta) ||
        !isset($request->texto_opcion) || trim($request->texto_opcion) === '' ||
        !isset($request->correcta)
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos los campos son obligatorios.']);
        exit();
    }

    $id_pregunta = (int) $request->id_pregunta;
    $texto_opcion = mysqli_real_escape_string($con, trim($request->texto_opcion));
    $correcta = (int) $request->correcta;

    $sql = "INSERT INTO opciones (id_pregunta, texto_opcion, correcta) 
            VALUES ($id_pregunta, '$texto_opcion', $correcta)";

    if (mysqli_query($con, $sql)) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'opcion' => [
                'id_pregunta' => $id_pregunta,
                'texto_opcion' => $texto_opcion,
                'correcta' => $correcta
            ]
        ]);
    } else {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
}
?>

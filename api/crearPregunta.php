<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);

    if (
        !isset($request->id_examen) ||
        !isset($request->pregunta) || trim($request->pregunta) === '' ||
        !isset($request->tipo) || trim($request->tipo) === '' ||
        !isset($request->puntaje) || trim($request->puntaje) === ''
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos los campos son obligatorios.']);
        exit();
    }

    $id_examen = (int) $request->id_examen;
    $pregunta = mysqli_real_escape_string($con, trim($request->pregunta));
    $tipo = mysqli_real_escape_string($con, trim($request->tipo));
    $puntaje = mysqli_real_escape_string($con, trim($request->puntaje));
    

    $sql = "INSERT INTO preguntas (id_examen, pregunta, tipo, puntaje) 
            VALUES ($id_examen, '$pregunta', '$tipo', '$puntaje')";

if (mysqli_query($con, $sql)) {
    $id_pregunta = mysqli_insert_id($con);  // <-- Aquí obtienes el ID insertado

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'id_pregunta' => $id_pregunta,  // <-- Devuelves este ID para Angular
        'pregunta' => [
            'id_examen' => $id_examen,
            'pregunta' => $pregunta,
            'tipo' => $tipo,
            'puntaje' => $puntaje,
        ]
    ]);
}
else {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
}
?>

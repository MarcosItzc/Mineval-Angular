<?php
require_once 'conexion.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

error_log(print_r($data, true)); 

$id_examen = $data['idExamen'] ?? null;
$id_estudiante = $data['idEstudiante'] ?? 1;
$respuestas = $data['respuestas'] ?? [];

if (!$id_examen || empty($respuestas)) {
    die(json_encode(["error" => "Datos incompletos."]));
}

try {
    $pdo->beginTransaction(); 

    $stmt = $pdo->prepare("INSERT INTO envios (Id_examen, Id_estudiante, calificacion) 
                           VALUES (:id_examen, :id_estudiante, 0)");
    $stmt->bindValue(':id_examen', $id_examen, PDO::PARAM_INT);
    $stmt->bindValue(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
    $stmt->execute();
    
    
    $id_envio = $pdo->lastInsertId();

    if (!$id_envio) {
        throw new Exception("No se pudo obtener el Id_envio.");
    }

    $stmt = $pdo->prepare("INSERT INTO respuestas (Id_envio, Id_pregunta, Id_opcion_seleccionada, respuesta, correcta) 
                           VALUES (:id_envio, :id_pregunta, :id_opcion, '', 0)");

    foreach ($respuestas as $id_pregunta => $id_opcion) {
        $stmt->bindValue(':id_envio', $id_envio, PDO::PARAM_INT);
        $stmt->bindValue(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
        $stmt->bindValue(':id_opcion', $id_opcion, PDO::PARAM_INT);
        $stmt->execute();
    }

    $pdo->commit();
    echo json_encode(["message" => "Respuestas guardadas.", "Id_envio" => $id_envio]);

} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error al guardar respuestas: " . $e->getMessage());
    echo json_encode(["error" => "Error al procesar el examen."]);
}
?>

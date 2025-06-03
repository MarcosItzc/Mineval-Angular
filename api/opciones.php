<?php
require_once 'conexion.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Manejo de preflight para CORS
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$id_pregunta = $_GET['id'] ?? null;

if (!$id_pregunta || !is_numeric($id_pregunta)) {
    die(json_encode(["error" => "ID de pregunta inválido."]));
}

try {
    $stmt = $pdo->prepare("SELECT * FROM opciones WHERE Id_pregunta = :id_pregunta");
    $stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
    $stmt->execute();
    
    $opciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($opciones);
} catch (PDOException $e) {
    error_log("Error en la consulta: " . $e->getMessage());
    echo json_encode(["error" => "Error al obtener opciones."]);
}
?>

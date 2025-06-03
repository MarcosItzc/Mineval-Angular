<?php
require_once 'conexion.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$id_envio = isset($_GET["idEnvio"]) ? intval($_GET["idEnvio"]) : 0;

if ($id_envio <= 0) {
    echo json_encode(["error" => "ID de envío inválido."]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS correctas
        FROM respuestas r
        JOIN opciones o ON r.Id_opcion_seleccionada = o.Id_opcion
        WHERE r.Id_envio = :id_envio AND o.correcta = 1
    ");
    $stmt->bindParam(':id_envio', $id_envio, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $correctas = $resultado['correctas'] ?? 0;

    $updateStmt = $pdo->prepare("
        UPDATE envios 
        SET calificacion = :calificacion 
        WHERE Id_envio = :id_envio
    ");
    $updateStmt->bindParam(':calificacion', $correctas, PDO::PARAM_INT);
    $updateStmt->bindParam(':id_envio', $id_envio, PDO::PARAM_INT);
    $updateStmt->execute();

    echo json_encode(["calificacion" => $correctas*10]);
} catch (PDOException $e) {
    error_log("Error al obtener la calificación: " . $e->getMessage());
    echo json_encode(["error" => "Error al obtener la calificación."]);
}
?>

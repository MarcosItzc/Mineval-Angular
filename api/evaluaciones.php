<?php
session_start();
require_once 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Manejo de preflight
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}


$stmt = $pdo->prepare("
    SELECT u.nombre, u.apellido, e.Id_examen, e.titulo, e.materia, e.intitucion, e.descripcion
    FROM examen e
    JOIN usuario u ON e.Id_profesor = u.Id_usuario
    WHERE u.rol = 2
");
$stmt->execute();
$examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($examenes);
?>
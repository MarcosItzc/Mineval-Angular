<?php
require_once "conexion.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['error' => 'Debes iniciar sesión para enviar respuestas.']);
    exit;
}

$id_estudiante = $_SESSION['usuario']['id_usuario'];
$nombre_estudiante = $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido'];
$id_examen = $_GET['id_examen'] ?? null;

if (!$id_examen) {
    echo json_encode(['error' => 'No se ha recibido el ID del examen.']);
    exit;
}

// Obtener los datos del examen
$stmt = $pdo->prepare("
    SELECT titulo, materia, intitucion, descripcion 
    FROM examen 
    WHERE Id_examen = :id_examen
");
$stmt->execute(['id_examen' => $id_examen]);
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$examen) {
    echo json_encode(['error' => 'El examen no existe.']);
    exit;
}

// Obtener los resultados del estudiante
$stmt = $pdo->prepare("
    SELECT COUNT(*) AS total_preguntas, 
           SUM(correcta) AS aciertos, 
           AVG(correcta * 100) AS calificacion_final
    FROM respuestas
    WHERE Id_envio IN (
        SELECT Id_envio FROM envios WHERE Id_examen = :id_examen AND id_estudiante = :id_estudiante
    )
");
$stmt->execute(['id_examen' => $id_examen, 'id_estudiante' => $id_estudiante]);
$resultados = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'examen' => $examen,
    'estudiante' => [
        'id' => $id_estudiante,
        'nombre' => $nombre_estudiante
    ],
    'totalPreguntas' => $resultados['total_preguntas'] ?? 0,
    'aciertos' => $resultados['aciertos'] ?? 0,
    'calificacionFinal' => round($resultados['calificacion_final'], 2) ?? 0
]);
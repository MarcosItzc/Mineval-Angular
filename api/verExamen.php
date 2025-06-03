<?php
require_once "conexion.php";
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No se ha proporcionado un ID de examen válido.']);
    exit;
}

$id_examen = $_GET['id'];

// Obtener los datos del examen
$stmt = $pdo->prepare("
    SELECT e.titulo, e.materia, e.intitucion, e.descripcion, u.nombre AS profesor_nombre, u.apellido AS profesor_apellido
    FROM examen e
    JOIN usuario u ON e.Id_profesor = u.Id_usuario
    WHERE e.Id_examen = :id_examen
");
$stmt->execute(['id_examen' => $id_examen]);
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$examen) {
    echo json_encode(['error' => 'El examen no existe.']);
    exit;
}

// Obtener las preguntas del examen
$stmt = $pdo->prepare("
    SELECT p.id_pregunta, p.pregunta, p.tipo
    FROM preguntas p
    WHERE p.Id_examen = :id_examen
");
$stmt->execute(['id_examen' => $id_examen]);
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las opciones de las preguntas
foreach ($preguntas as &$pregunta) {
    if ($pregunta['tipo'] == 2) {
        $stmt = $pdo->prepare("
            SELECT Id_opcion AS id_opcion, texto_opcion
            FROM opciones
            WHERE Id_pregunta = :id_pregunta
        ");
        $stmt->execute(['id_pregunta' => $pregunta['id_pregunta']]);
        $pregunta['opciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

echo json_encode(['examen' => $examen, 'preguntas' => $preguntas]);
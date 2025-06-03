<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT * FROM examen";
$result = mysqli_query($con, $sql);

$examenes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $examenes[] = $row;
}

echo json_encode($examenes);
?>

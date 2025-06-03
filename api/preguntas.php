<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT * FROM preguntas";
$result = mysqli_query($con, $sql);

$preguntas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $preguntas[] = $row;
}

echo json_encode($preguntas);
?>

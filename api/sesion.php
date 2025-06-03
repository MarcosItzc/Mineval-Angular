<?php
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");   
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");  
header("Access-Control-Allow-Credentials: true");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'success' => true,
        'usuario' => $_SESSION['usuario']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No hay usuario autenticado.'
    ]);
}
error_log("Estado actual de la sesión: " . json_encode($_SESSION));
?>

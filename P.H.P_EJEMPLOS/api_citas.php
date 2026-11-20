<?php
require_once __DIR__ . '/conexion.php';
header('Content-Type: application/json; charset=utf-8');

$fecha = $_GET['fecha'] ?? '';

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    echo json_encode(['bloqueadas' => []]);
    exit;
}

try {
    $sql = "SELECT DISTINCT TIME_FORMAT(hora, '%H:%i') AS hora_corta
            FROM citas
            WHERE fecha = :fecha
              AND estado IN ('Aprobada', 'Confirmada')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':fecha' => $fecha]);
    $bloqueadas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(['bloqueadas' => $bloqueadas]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['bloqueadas' => []]);
}
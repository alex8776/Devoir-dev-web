<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de la matière requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$matiere = new Matiere($conn);
$result = $matiere->getById($id);

if ($result) {
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Matière introuvable."]);
}

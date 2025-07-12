<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


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
$success = $matiere->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Matière supprimée." : "Impossible de supprimer cette matière."
]);

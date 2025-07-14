<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Coef.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID du coefficient requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$coef = new Coef($conn);
$success = $coef->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Coefficient supprimé." : "Impossible de supprimer ce coefficient."
]);

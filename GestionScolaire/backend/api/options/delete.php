<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Filiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de l'option requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$option = new Filiere($conn);
$success = $option->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Option supprimée." : "Impossible de supprimer cette option."
]);

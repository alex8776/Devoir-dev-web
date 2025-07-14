<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Eleve.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID manquant."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$eleve = new Eleve($conn);
$success = $eleve->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Élève supprimé." : "Échec de la suppression."
]);

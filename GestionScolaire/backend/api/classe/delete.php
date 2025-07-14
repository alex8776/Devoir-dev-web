<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Classe.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de la classe requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$classe = new Classe($conn);
$success = $classe->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Classe supprimée." : "Impossible de supprimer cette classe (liée à des élèves ?)."
]);

<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Note.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de la note requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$note = new Note($conn);
$success = $note->delete($id);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Note supprimée." : "Impossible de supprimer cette note."
]);

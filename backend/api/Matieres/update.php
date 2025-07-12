<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$id || !$data || empty($data['nom'])) {
    http_response_code(400);
    echo json_encode(["message" => "ID et nom de la matière requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$matiere = new Matiere($conn);
$success = $matiere->update($id, $data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Matière mise à jour." : "Erreur lors de la mise à jour."
]);

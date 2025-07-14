<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Filiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$id || !$data || empty($data['nom'])) {
    http_response_code(400);
    echo json_encode(["message" => "ID ou nom manquant."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$option = new Filiere($conn);
$success = $option->update($id, $data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Option mise à jour." : "Erreur de mise à jour."
]);

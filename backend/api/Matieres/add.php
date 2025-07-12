<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['nom'])) {
    http_response_code(400);
    echo json_encode(["message" => "Le nom de la matière est requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$matiere = new Matiere($conn);
$success = $matiere->create($data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Matière ajoutée avec succès." : "Erreur lors de l'ajout."
]);

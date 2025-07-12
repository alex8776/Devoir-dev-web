<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Filiere.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['nom'])) {
    http_response_code(400);
    echo json_encode(["message" => "Le nom de l'option est requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$option = new Filiere($conn);
$success = $option->create($data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Option ajoutée avec succès." : "Erreur lors de l'ajout."
]);

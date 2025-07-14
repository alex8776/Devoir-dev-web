<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Annee.php';
require_once __DIR__ . '/../../utils/auth.php';

require_auth();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['libelle']) || empty(trim($data['libelle']))) {
    http_response_code(400);
    echo json_encode(["message" => "Le champ 'libelle' est requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$annee = new Annee($conn);
$success = $annee->create(trim($data['libelle']));

echo json_encode([
    "success" => $success,
    "message" => $success ? "Année ajoutée avec succès." : "Échec de l’ajout."
]);

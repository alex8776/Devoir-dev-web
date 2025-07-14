<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Classe.php';
require_once __DIR__ . '/../../utils/auth.php';


require_auth();

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data ||
    empty($data['nom']) || 
    !isset($data['annee_id']) || 
    !isset($data['option_id'])
) {
    http_response_code(400);
    echo json_encode(["message" => "nom, option_id et annee_id sont requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$classe = new Classe($conn);
$success = $classe->create($data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Classe ajoutée avec succès." : "Échec de l'ajout."
]);

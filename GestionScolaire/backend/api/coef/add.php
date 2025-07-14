<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Coef.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data ||
    empty($data['matiere_id']) ||
    empty($data['classe_id']) ||
    !isset($data['coefficient']) ||
    empty($data['annee_id'])
) {
    http_response_code(400);
    echo json_encode(["message" => "matiere_id, classe_id, coefficient et annee_id sont requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$coef = new Coef($conn);
$success = $coef->create($data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Coefficient ajouté avec succès." : "Erreur lors de l'ajout."
]);

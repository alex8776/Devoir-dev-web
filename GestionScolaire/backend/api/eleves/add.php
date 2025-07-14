<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Eleve.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    empty($data['nom']) || 
    empty($data['prenom']) || 
    empty($data['genre']) ||
    empty($data['date_naissance']) ||
    empty($data['classe_id']) || 
    empty($data['filiere_id']) ||
    empty($data['annee_id'])
) {
    http_response_code(400);
    echo json_encode(["message" => "Tous les champs sont requis."]);
    exit;
}


$db = new Database();
$conn = $db->getConnection();

$eleve = new Eleve($conn);
$success = $eleve->create($data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Élève ajouté avec succès." : "Échec lors de l'ajout."
]);

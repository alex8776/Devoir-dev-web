<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Eleve.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (
    !$id || 
    !$data || 
    empty($data['nom']) || 
    empty($data['prenom']) || 
    empty($data['classe_id']) || 
    empty($data['annee_id'])
) {
    http_response_code(400);
    echo json_encode(["message" => "ID, nom, prenom, classe_id et annee_id sont requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$eleve = new Eleve($conn);
$success = $eleve->update($id, $data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Élève modifié." : "Échec de la modification."
]);

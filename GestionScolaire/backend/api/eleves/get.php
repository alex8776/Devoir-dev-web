<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Eleve.php';


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de l'élève requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$eleve = new Eleve($conn);
$result = $eleve->getById($id, $annee_id);

if ($result) {
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Élève introuvable."]);
}

<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Classe.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de la classe requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$classe = new Classe($conn);
$result = $classe->getById($id, $annee_id);

if ($result) {
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Classe introuvable."]);
}

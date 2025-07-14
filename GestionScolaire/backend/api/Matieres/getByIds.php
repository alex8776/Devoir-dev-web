<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';
require_once __DIR__ . '/../../utils/auth.php';

require_auth();

header('Content-Type: application/json');

// On attend un JSON avec un tableau d'IDs, ex : { "ids": [1, 2, 3] }
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ids']) || !is_array($data['ids']) || empty($data['ids'])) {
    http_response_code(400);
    echo json_encode(["message" => "Un tableau d'IDs est requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$matiere = new Matiere($conn);
$result = $matiere->getByIds($data['ids']);

echo json_encode($result);

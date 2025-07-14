<?php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();

header('Content-Type: application/json');

$annee_id = $_GET['annee_id'] ?? null;
if (!$annee_id) {
    http_response_code(400);
    echo json_encode(["message" => "annee_id requis"]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT COUNT(*) as total_eleves FROM Eleve WHERE annee_id = :annee_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['annee_id' => $annee_id]);
$result = $stmt->fetch();

echo json_encode($result);

?>
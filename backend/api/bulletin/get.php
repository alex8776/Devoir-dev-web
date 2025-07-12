<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Bulletin.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();

header('Content-Type: application/json');

$eleve_id = $_GET['eleve_id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;
$periode  = $_GET['periode'] ?? null;

if (!$eleve_id || !$annee_id || !$periode) {
    http_response_code(400);
    echo json_encode(["message" => "Paramètres manquants (eleve_id, annee_id, période)."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$bulletin = new Bulletin($conn);
$data = $bulletin->generate($eleve_id, $annee_id, $periode);

if ($data) {
    echo json_encode($data);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Aucun bulletin trouvé pour cet élève."]);
}

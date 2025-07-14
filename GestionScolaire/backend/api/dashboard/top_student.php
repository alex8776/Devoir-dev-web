<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();

header('Content-Type: application/json');

$annee_id = $_GET['annee_id'] ?? null;
$periode = $_GET['periode'] ?? null;

if (!$annee_id || !$periode) {
    http_response_code(400);
    echo json_encode(["message" => "annee_id et periode sont requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$sql = "
    SELECT 
        b.eleve_id,
        e.nom,
        e.prenom,
        b.moyenne
    FROM Bulletin b
    JOIN Eleve e ON b.eleve_id = e.id
    WHERE b.annee_id = :annee_id AND b.periode = :periode
    ORDER BY b.moyenne DESC
    LIMIT 5
";

$stmt = $conn->prepare($sql);
$stmt->execute([
    'annee_id' => $annee_id,
    'periode' => $periode
]);

$top_students = $stmt->fetchAll();

echo json_encode($top_students);

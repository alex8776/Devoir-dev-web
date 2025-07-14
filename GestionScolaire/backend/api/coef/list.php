<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Coef.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$coef = new Coef($conn);

$matiere_id = $_GET['matiere_id'] ?? null;
$classe_id = $_GET['classe_id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;

if ($matiere_id && $classe_id && $annee_id) {
    $result = [$coef->getByMatiereClasseAnnee($matiere_id, $classe_id, $annee_id)];
} elseif ($annee_id) {
    $result = $coef->getAll($annee_id);
} else {
    $result = $coef->getAll();
}

echo json_encode($result);

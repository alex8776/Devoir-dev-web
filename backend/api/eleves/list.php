<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Eleve.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$eleve = new Eleve($conn);

$classe_id = $_GET['classe_id'] ?? null;
$option_id = $_GET['option_id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;

if ($classe_id && $annee_id) {
    $result = $eleve->getByClasseOptionAnnee($classe_id, $option_id, $annee_id);
} elseif ($annee_id) {
    $result = $eleve->getByAnnee($annee_id);
} else {
    $result = $eleve->getAll();
}

echo json_encode($result);

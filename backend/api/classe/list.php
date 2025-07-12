<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Classe.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$classe = new Classe($conn);

$annee_id = $_GET['annee_id'] ?? null;

if ($annee_id) {
    $result = $classe->getByAnnee($annee_id);
} else {
    $result = $classe->getAll();
}

echo json_encode($result);

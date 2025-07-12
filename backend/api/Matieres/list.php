<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Matiere.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$matiere = new Matiere($conn);

// On ne filtre pas sur classe_id ici
$result = $matiere->getAll();

echo json_encode($result);

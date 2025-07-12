<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Annee.php';


header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$annee = new Annee($conn);
$data = $annee->getAll();

echo json_encode($data);

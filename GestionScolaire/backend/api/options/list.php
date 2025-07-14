<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Filiere.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$option = new Filiere($conn);
$result = $option->getAll();

echo json_encode($result);

<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Note.php';
require_once __DIR__ . '/../../utils/auth.php';
require_auth();

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

$required = ['eleve_id', 'matiere_id', 'annee_id', 'type_note', 'valeur', 'date_note', 'periode'];
foreach ($required as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(["message" => "Le champ '$field' est requis."]);
        exit;
    }
}

$db = new Database();
$conn = $db->getConnection();

$note = new Note($conn);
$success = $note->update($id, $data);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Note mise à jour." : "Erreur lors de la mise à jour."
]);

<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Note.php';
require_once __DIR__ . '/../../utils/auth.php';

require_auth();

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['notes']) || !is_array($data['notes']) || count($data['notes']) === 0) {
    http_response_code(400);
    echo json_encode(["message" => "Un tableau 'notes' non vide est requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$noteModel = new Note($conn);

$allValid = true;
foreach ($data['notes'] as $note) {
    $requiredFields = ['eleve_id', 'matiere_id', 'annee_id', 'type_note', 'valeur', 'date_note','periode'];
    foreach ($requiredFields as $field) {
        if (!isset($note[$field])) {
            http_response_code(400);
            echo json_encode(["message" => "Le champ '$field' est requis dans chaque note."]);
            exit;
        }
    }
}

// Appel à la méthode createMany() qui utilise une transaction
$success = $noteModel->createMany($data['notes']);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Toutes les notes ont été ajoutées avec succès." : "Erreur lors de l'ajout des notes."
]);

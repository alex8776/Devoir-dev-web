<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Note.php';
require_once __DIR__ . '/../../models/Eleve.php';
require_once __DIR__ . '/../../models/Coef.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID de la note requis."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$noteModel = new Note($conn);
$note = $noteModel->getById($id);

if ($note) {
    $eleveModel = new Eleve($conn);
    $coefModel = new Coef($conn);
    $eleve = $eleveModel->getById($note['eleve_id']);

    if ($eleve) {
        $coef = $coefModel->getByMatiereClasseAnnee(
            $note['matiere_id'],
            $eleve['classe_id'],
            $note['annee_id']
        );
        $note['coefficient'] = $coef['coefficient'] ?? null;
    }

    echo json_encode($note);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Note introuvable."]);
}

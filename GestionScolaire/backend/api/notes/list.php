<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Note.php';
require_once __DIR__ . '/../../models/Eleve.php';
require_once __DIR__ . '/../../models/Coef.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$noteModel = new Note($conn);
$eleveModel = new Eleve($conn);
$coefModel = new Coef($conn);

$eleve_id = $_GET['eleve_id'] ?? null;
$matiere_id = $_GET['matiere_id'] ?? null;
$annee_id = $_GET['annee_id'] ?? null;
$periode = $_GET['periode'] ?? null;

$params = [];
$sqlFilter = [];

if ($eleve_id) {
    $sqlFilter[] = "eleve_id = :eleve_id";
    $params['eleve_id'] = $eleve_id;
}
if ($matiere_id) {
    $sqlFilter[] = "matiere_id = :matiere_id";
    $params['matiere_id'] = $matiere_id;
}
if ($annee_id) {
    $sqlFilter[] = "annee_id = :annee_id";
    $params['annee_id'] = $annee_id;
}
if ($periode) {
    $sqlFilter[] = "periode = :periode";
    $params['periode'] = $periode;
}

$notes = count($sqlFilter) > 0
    ? $noteModel->getFiltered($sqlFilter, $params)
    : $noteModel->getAll();

foreach ($notes as &$note) {
    $eleve = $eleveModel->getById($note['eleve_id']);
    if ($eleve) {
        $coef = $coefModel->getByMatiereClasseAnnee(
            $note['matiere_id'],
            $eleve['classe_id'],
            $note['annee_id']
        );
        $note['coefficient'] = $coef['coefficient'] ?? null;
    } else {
        $note['coefficient'] = null;
    }
}

echo json_encode($notes);

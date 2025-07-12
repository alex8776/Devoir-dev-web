<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../utils/auth.php';

header('Content-Type: application/json');

// Récupération des données envoyées (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Vérification des champs requis
if (
    !isset($data['username']) ||
    !isset($data['password'])
) {
    http_response_code(400);
    echo json_encode(["message" => "Le nom d'utilisateur et le mot de passe sont requis."]);
    exit;
}

// Connexion à la base de données
$db = new Database();
$conn = $db->getConnection();

// Vérification de l'existence de l'utilisateur
$sql = "SELECT * FROM Admin WHERE username = :username LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $data['username']]);
$user = $stmt->fetch();

if (!$user) {
    http_response_code(401);
    echo json_encode(["message" => "Utilisateur introuvable"]);
    exit;
}

// Vérification du mot de passe
if (!password_verify($data['password'], $user['password'])) {
    http_response_code(401);
    echo json_encode(["message" => "Mot de passe incorrect."]);
    exit;
}

// Authentification réussie : création de la session
login($user);

echo json_encode([
    "success" => true,
    "message" => "Connexion réussie.",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "role" => $user['role'] ?? 'admin'
    ]
]);

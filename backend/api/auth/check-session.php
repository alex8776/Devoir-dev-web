<?php
require_once __DIR__ . '/../../utils/auth.php';

header('Content-Type: application/json');

if (isAuthenticated()) {
    echo json_encode([
        "authenticated" => true,
        "user" => $_SESSION['user'] // optionnel
    ]);
} else {
    http_response_code(401);
    echo json_encode(["authenticated" => false]);
}

/**
 * Vérifie si un utilisateur est connecté sans interrompre.
 * @return bool
 */
function isAuthenticated() {
    return isset($_SESSION['user']);
}

<?php
// utils/auth.php

session_start();

/**
 * Vérifie si l'utilisateur est connecté.
 * Redirige vers la page de connexion si ce n'est pas le cas.
 */
function require_auth() {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(["message" => "Non autorisé. Veuillez vous connecter."]);
        exit;
    }
}

/**
 * Connecte un utilisateur (après vérification des identifiants)
 */
function login($user_data) {
    $_SESSION['user'] = [
        'id' => $user_data['id'],
        'username' => $user_data['username'],
        'role' => $user_data['role'] ?? 'admin',
    ];
}

/**
 * Déconnecte l'utilisateur
 */
function logout() {
    session_unset();
    session_destroy();
}

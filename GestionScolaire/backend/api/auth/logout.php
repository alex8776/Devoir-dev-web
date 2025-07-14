<?php
// api/auth/logout.php

require_once __DIR__ . '/../../utils/auth.php';

header('Content-Type: application/json');

// Déconnecte l'utilisateur
logout();

// Réponse JSON claire
echo json_encode([
    "success" => true,
    "message" => "Déconnexion réussie."
]);

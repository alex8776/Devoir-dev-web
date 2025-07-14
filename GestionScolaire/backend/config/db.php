<?php
// backend/config/db.php

class Database {
    private $host = "127.0.0.1";        // adresse du serveur MariaDB
    private $db_name = "gestionscolaire"; // remplace par le nom de ta base
    private $username = "root";     // ton utilisateur MariaDB
    private $password = "souleymane2008";      // ton mot de passe
    public $conn;

    // Méthode pour récupérer la connexion PDO
    public function getConnection() {
        $this->conn = null;
        try {
            // Les flèches -> en PHP sont utilisées pour accéder aux propriétés ou méthodes d'un objet.
            // Par exemple, $this->host accède à la propriété 'host' de l'objet courant.
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,          // Lancer exceptions en cas d'erreur
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // fetch assoc par défaut
                PDO::ATTR_EMULATE_PREPARES => false,                   // Utiliser les vrais prepares statements
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            echo "Erreur de connexion à la base : " . $exception->getMessage();
            exit; // Arrêter l'exécution si erreur critique
        }

        return $this->conn;
    }
}

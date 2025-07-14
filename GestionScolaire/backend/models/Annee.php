<?php

class Annee {
    private $conn;
    private $table = "Annee";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($libelle) {
        $query = "INSERT INTO " . $this->table . " (libelle) VALUES (:libelle)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":libelle", $libelle);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT id, libelle FROM " . $this->table . " ORDER BY libelle DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

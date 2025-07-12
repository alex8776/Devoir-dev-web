<?php
// models/Filiere.php

class Filiere {
    private $conn;
    private $table = "Filiere";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Récupérer toutes les options
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY libelle";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer une option par ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // 🆕 Créer une nouvelle option
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (nom) VALUES (:nom)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['nom' => $data['nom']]);
    }

    // ✏️ Mettre à jour une option
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET nom = :nom WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // ❌ Supprimer une option
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

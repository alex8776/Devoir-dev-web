<?php
// models/Matiere.php

class Matiere {
    private $conn;
    private $table = "Matiere";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Récupérer toutes les matières
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nom";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer une matière par ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // 🔍 Récupérer plusieurs matières par un tableau d’IDs
    public function getByIds(array $ids) {
        if (empty($ids)) return [];

        // Crée des placeholders :id0, :id1, etc.
        $placeholders = implode(',', array_map(fn($i) => ":id_$i", array_keys($ids)));
        $sql = "SELECT * FROM {$this->table} WHERE id IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        $params = [];
        foreach ($ids as $i => $val) {
            $params[":id_$i"] = $val;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_UNIQUE); // Résultat indexé par ID
    }

    // ➕ Ajouter une matière
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (nom) VALUES (:nom)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom']
        ]);
    }

    // ✏️ Modifier une matière
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET nom = :nom WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom'],
            'id' => $id
        ]);
    }

    // ❌ Supprimer une matière
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

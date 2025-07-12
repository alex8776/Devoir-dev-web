<?php
// models/BulletinDetail.php

class BulletinDetail {
    private $conn;
    private $table = "BulletinDetail";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ajouter un détail de bulletin (une matière)
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (bulletin_id, matiere_id, note, coefficient)
                VALUES (:bulletin_id, :matiere_id, :note, :coefficient)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'bulletin_id' => $data['bulletin_id'],
            'matiere_id' => $data['matiere_id'],
            'note' => $data['note'],
            'coefficient' => $data['coefficient'],
        ]);
    }

    // Récupérer les détails d'un bulletin (toutes les matières)
    public function getByBulletinId($bulletin_id) {
        $sql = "SELECT bd.*, m.nom AS matiere_nom
                FROM {$this->table} bd
                JOIN Matiere m ON bd.matiere_id = m.id
                WHERE bd.bulletin_id = :bulletin_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['bulletin_id' => $bulletin_id]);
        return $stmt->fetchAll();
    }

    // Mettre à jour un détail de bulletin
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET
                    note = :note,
                    coefficient = :coefficient
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'note' => $data['note'],
            'coefficient' => $data['coefficient'],
            'id' => $id
        ]);
    }

    // Supprimer un détail
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Supprimer tous les détails d'un bulletin
    public function deleteByBulletinId($bulletin_id) {
        $sql = "DELETE FROM {$this->table} WHERE bulletin_id = :bulletin_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['bulletin_id' => $bulletin_id]);
    }
}

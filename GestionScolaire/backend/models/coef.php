<?php
// models/Coef.php

class Coef {
    private $conn;
    private $table = "Coef";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Récupérer tous les coefficients (optionnellement filtrés par année)
    public function getAll($annee_id = null) {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if ($annee_id !== null) {
            $sql .= " WHERE annee_id = :annee_id";
            $params['annee_id'] = $annee_id;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer un coefficient par ID (avec année en option)
    public function getById($id, $annee_id = null) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];

        if ($annee_id !== null) {
            $sql .= " AND annee_id = :annee_id";
            $params['annee_id'] = $annee_id;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // 🔍 Récupérer coefficient par matière, classe et année
    public function getByMatiereClasseAnnee($matiere_id, $classe_id, $annee_id) {
        $sql = "SELECT * FROM {$this->table} WHERE matiere_id = :matiere_id AND classe_id = :classe_id AND annee_id = :annee_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'matiere_id' => $matiere_id,
            'classe_id' => $classe_id,
            'annee_id' => $annee_id
        ]);
        return $stmt->fetch();
    }

    // 🆕 Ajouter un coefficient
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (matiere_id, classe_id, annee_id, coefficient)
                VALUES (:matiere_id, :classe_id, :annee_id, :coefficient)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'matiere_id' => $data['matiere_id'],
            'classe_id' => $data['classe_id'],
            'annee_id' => $data['annee_id'],
            'coefficient' => $data['coefficient']
        ]);
    }

    // ✏️ Modifier un coefficient
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET matiere_id = :matiere_id,
                    classe_id = :classe_id,
                    annee_id = :annee_id,
                    coefficient = :coefficient
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // ❌ Supprimer un coefficient
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

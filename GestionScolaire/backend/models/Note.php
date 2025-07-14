<?php
// models/Note.php

class Note {
    private $conn;
    private $table = "Note";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Récupérer toutes les notes (non recommandé sans pagination)
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY date_note DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer une note par ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // 🔍 Récupérer les notes d'un élève sur une année
    public function getByEleveAnnee($eleve_id, $annee_id) {
        $sql = "SELECT * FROM {$this->table}
                WHERE eleve_id = :eleve_id AND annee_id = :annee_id
                ORDER BY date_note DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'eleve_id' => $eleve_id,
            'annee_id' => $annee_id
        ]);
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer des notes selon filtres dynamiques
    public function getFiltered(array $filters, array $params) {
        $where = implode(" AND ", $filters);
        $sql = "SELECT * FROM {$this->table} WHERE $where ORDER BY date_note DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // ➕ Créer une note
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (eleve_id, matiere_id, annee_id, type_note, valeur, date_note, periode)
                VALUES (:eleve_id, :matiere_id, :annee_id, :type_note, :valeur, :date_note, :periode)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'eleve_id' => $data['eleve_id'],
            'matiere_id' => $data['matiere_id'],
            'annee_id' => $data['annee_id'],
            'type_note' => $data['type_note'],
            'valeur' => $data['valeur'],
            'date_note' => $data['date_note'],
            'periode' => $data['periode']
        ]);
    }

    // ✏️ Modifier une note
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET
                    eleve_id = :eleve_id,
                    matiere_id = :matiere_id,
                    annee_id = :annee_id,
                    type_note = :type_note,
                    valeur = :valeur,
                    date_note = :date_note,
                    periode = :periode
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'eleve_id' => $data['eleve_id'],
            'matiere_id' => $data['matiere_id'],
            'annee_id' => $data['annee_id'],
            'type_note' => $data['type_note'],
            'valeur' => $data['valeur'],
            'date_note' => $data['date_note'],
            'periode' => $data['periode'],
            'id' => $id,
        ]);
    }

    // ❌ Supprimer une note
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function createMany(array $notes) {
    try {
        $this->conn->beginTransaction();
        $sql = "INSERT INTO {$this->table} 
                (eleve_id, matiere_id, annee_id, type_note, valeur, date_note)
                VALUES (:eleve_id, :matiere_id, :annee_id, :type_note, :valeur, :date_note,:periode)";
        $stmt = $this->conn->prepare($sql);

        foreach ($notes as $note) {
            $stmt->execute([
                'eleve_id' => $note['eleve_id'],
                'matiere_id' => $note['matiere_id'],
                'annee_id' => $note['annee_id'],
                'type_note' => $note['type_note'],
                'valeur' => $note['valeur'],
                'date_note' => $note['date_note'],
                'periode' => $note['periode']
            ]);
        }

        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        $this->conn->rollBack();
        return false;
    }
}

}

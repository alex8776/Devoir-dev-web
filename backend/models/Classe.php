<?php
// models/Classe.php

class Classe {
    private $conn;
    private $table = "Classe";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Récupérer toutes les classes (optionnellement filtrées par annee_id)
    public function getAll($annee_id = null) {
        if ($annee_id) {
            $sql = "SELECT * FROM {$this->table} WHERE annee_id = :annee_id ORDER BY nom";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['annee_id' => $annee_id]);
        } else {
            $sql = "SELECT * FROM {$this->table} ORDER BY nom";
            $stmt = $this->conn->query($sql);
        }
        return $stmt->fetchAll();
    }

    // 🔍 Récupérer une classe par ID ET annee_id (plus sûr pour éviter ambiguïté)
    public function getById($id, $annee_id = null) {
        if ($annee_id) {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id AND annee_id = :annee_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id, 'annee_id' => $annee_id]);
        } else {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
        }
        return $stmt->fetch();
    }

    // 🆕 Créer une classe (annee_id obligatoire)
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (nom, option_id, annee_id)
                VALUES (:nom, :option_id, :annee_id)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nom'       => $data['nom'],
            'option_id' => $data['option_id'],
            'annee_id'  => $data['annee_id']
        ]);
    }

    // ✏️ Modifier une classe (annee_id obligatoire)
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET nom = :nom,
                    option_id = :option_id,
                    annee_id = :annee_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // ❌ Supprimer une classe
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // 📂 Liste des classes pour une année scolaire donnée (méthode utile mais redondante avec getAll($annee_id))
    public function getByAnnee($annee_id) {
        return $this->getAll($annee_id);
    }
    
    public function getByClasseOption($classe_id, $option_id = null) {
    $sql = "SELECT e.* FROM Eleve e
            JOIN Classe c ON e.classe_id = c.id
            WHERE e.classe_id = :classe_id";

    $params = ['classe_id' => $classe_id];

    if ($option_id !== null) {
        $sql .= " AND c.option_id = :option_id";
        $params['option_id'] = $option_id;
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
}


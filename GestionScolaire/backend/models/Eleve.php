<?php
// models/Eleve.php

class Eleve {
    private $conn;
    private $table = "Eleve";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔍 Lire tous les élèves
    // Get all students from the database
    public function getAll($filters = []) {
        $query = "SELECT 
                    e.id, e.nom, e.prenom, e.genre, e.date_naissance,
                    c.nom AS classe,
                    f.libelle AS filiere
                FROM eleve e
                LEFT JOIN classe c ON e.classe_id = c.id
                LEFT JOIN filiere f ON e.filiere_id = f.id
                WHERE 1=1";

        if (!empty($filters['filiere_id'])) {
            $query .= " AND e.filiere_id = :filiere_id";
        }
        if (!empty($filters['classe_id'])) {
            $query .= " AND e.classe_id = :classe_id";
        }
        if (!empty($filters['nom'])) {
            $query .= " AND e.nom LIKE :nom";
        }
        if (!empty($filters['prenom'])) {
            $query .= " AND e.prenom LIKE :prenom";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($filters['filiere_id'])) {
            $stmt->bindParam(':filiere_id', $filters['filiere_id']);
        }
        if (!empty($filters['classe_id'])) {
            $stmt->bindParam(':classe_id', $filters['classe_id']);
        }
        if (!empty($filters['nom'])) {
            $likeNom = '%' . $filters['nom'] . '%';
            $stmt->bindParam(':nom', $likeNom);
        }
        if (!empty($filters['prenom'])) {
            $likePrenom = '%' . $filters['prenom'] . '%';
            $stmt->bindParam(':prenom', $likePrenom);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // 🔍 Lire un élève par ID
    // Get a single student by their ID
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

    // 🆕 Ajouter un élève
    // Create a new student record
    public function create($data) {
        $sql = "INSERT INTO Eleve (nom, prenom, genre, date_naissance, classe_id, filiere_id, annee_id)
                VALUES (:nom, :prenom, :genre, :date_naissance, :classe_id, :filiere_id, :annee_id)";
        
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'genre' => $data['genre'],
            'date_naissance' => $data['date_naissance'],
            'classe_id' => $data['classe_id'],
            'filiere_id' => $data['filiere_id'], // bien penser à ce nom
            'annee_id' => $data['annee_id']
        ]);
}


    // ✏️ Modifier un élève
    // Update an existing student's information
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET nom = :nom,
                    prenom = :prenom,
                    date_naissance = :date_naissance,
                    sexe = :sexe,
                    classe_id = :classe_id,
                    filiere_id = :filiere_id,
                    annee_id = :annee_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // ❌ Supprimer un élève
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // 📂 Liste des élèves par classe et/ou option
    
    public function getByClasseOptionAnnee($classe_id, $filiere_id = null, $annee_id = null) {
        $sql = "SELECT * FROM {$this->table} WHERE classe_id = :classe_id";
        $params = ['classe_id' => $classe_id];

        if ($filiere_id !== null) {
            $sql .= " AND filiere_id = :filiere_id";
            $params['filiere_id'] = $filiere_id;
        }

        if ($annee_id !== null) {
            $sql .= " AND annee_id = :annee_id";
            $params['annee_id'] = $annee_id;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}

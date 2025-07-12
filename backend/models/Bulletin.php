<?php
// models/Bulletin.php

require_once __DIR__ . '/Note.php';
require_once __DIR__ . '/Matiere.php';
require_once __DIR__ . '/Coef.php';

class Bulletin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function generate($eleve_id, $annee_id, $periode) {
        $noteModel = new Note($this->conn);
        $coefModel = new Coef($this->conn);
        $matiereModel = new Matiere($this->conn);

        // 🔹 Étape 1 — Charger toutes les notes de l'élève
        $filters = [
            "eleve_id = :eleve_id",
            "annee_id = :annee_id",
            "periode = :periode"
        ];
        $params = [
            'eleve_id' => $eleve_id,
            'annee_id' => $annee_id,
            'periode' => $periode
        ];
        $notes = $noteModel->getFiltered($filters, $params);

        if (empty($notes)) return null;

        // 🔹 Étape 2 — Regrouper par matière
        $matiere_notes = [];
        foreach ($notes as $note) {
            $matiere_id = $note['matiere_id'];
            if (!isset($matiere_notes[$matiere_id])) {
                $matiere_notes[$matiere_id] = [];
            }
            $matiere_notes[$matiere_id][] = $note;
        }

        // 🔹 Étape 3 — Charger les coefficients & noms des matières
        $matiere_ids = array_keys($matiere_notes);
        $coefs = [];
        $matiere_infos = $matiereModel->getByIds($matiere_ids);

        foreach ($matiere_ids as $id) {
            $coef_data = $coefModel->getByMatiereEleveAnnee($id, $eleve_id, $annee_id);
            $coefs[$id] = $coef_data['coefficient'] ?? 1;
        }

        // 🔹 Étape 4 — Calcul des moyennes par matière
        $bulletin_data = [
            "eleve_id" => $eleve_id,
            "annee_id" => $annee_id,
            "periode" => $periode,
            "matieres" => [],
            "moyenne_generale" => 0,
            "mention" => ""
        ];

        $total_points = 0;
        $total_coefficients = 0;

        foreach ($matiere_notes as $matiere_id => $notes_array) {
            $somme_notes = 0;
            $somme_coeff = 0;
            $formatted_notes = [];

            foreach ($notes_array as $note) {
                $coef = $coefs[$matiere_id] ?? 1;
                $valeur = floatval($note['valeur']);
                $somme_notes += $valeur * $coef;
                $somme_coeff += $coef;

                $formatted_notes[] = [
                    "type" => $note['type_note'],
                    "valeur" => $valeur,
                    "coefficient" => $coef,
                    "matiere" => $matiere_infos[$matiere_id]['nom'] ?? "Inconnu"
                ];
            }

            $moyenne = $somme_coeff > 0 ? round($somme_notes / $somme_coeff, 2) : 0;
            $appr = $this->apprFromMoyenne($moyenne);

            $bulletin_data['matieres'][] = [
                "matiere_id" => $matiere_id,
                "notes" => $formatted_notes,
                "moyenne" => $moyenne,
                "appreciation" => $appr
            ];

            $total_points += $moyenne * $coefs[$matiere_id];
            $total_coefficients += $coefs[$matiere_id];
        }

        // 🔹 Étape 5 — Moyenne générale et mention
        $moy_gen = $total_coefficients > 0 ? round($total_points / $total_coefficients, 2) : 0;
        $bulletin_data['moyenne_generale'] = $moy_gen;
        $bulletin_data['mention'] = $this->mentionFromMoyenne($moy_gen);

        return $bulletin_data;
    }

    private function apprFromMoyenne($moyenne) {
        if ($moyenne >= 16) return "Très bien";
        if ($moyenne >= 14) return "Bien";
        if ($moyenne >= 12) return "Assez bien";
        if ($moyenne >= 10) return "Passable";
        return "Insuffisant";
    }

    private function mentionFromMoyenne($moyenne) {
        if ($moyenne >= 16) return "Félicitations";
        if ($moyenne >= 14) return "Très bien";
        if ($moyenne >= 12) return "Bien";
        if ($moyenne >= 10) return "Encouragement";
        return "Redoublement";
    }
}

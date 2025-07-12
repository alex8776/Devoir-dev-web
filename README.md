# 📚 Gestion Scolaire

**Gestion Scolaire** est une application web complète permettant de gérer les inscriptions, les classes, les filières, les élèves, les matières, les notes et les bulletins dans un établissement scolaire.

---

## 🏗️ Structure générale

Le projet est divisé en deux parties principales :

- **Frontend** : HTML, CSS et JavaScript Vanilla  
- **Backend** : PHP procédural + PDO (orienté API REST)

---

## ✅ Fonctionnalités actuelles

### 🎓 Inscriptions
- Ajout d’élèves avec :
  - nom, prénom, genre, date de naissance
  - classe, filière, année scolaire
- Chargement dynamique des listes déroulantes depuis l'API
- Validation côté client et serveur

### 👨‍🎓 Liste des élèves
- Affichage sous forme de tableau
- Filtres dynamiques :
  - par filière
  - par classe
  - par nom ou prénom
- Recherche combinée
- Résultats affichés en temps réel

### 📊 Notes (en cours de développement)
- Tableau dynamique des élèves et de leurs notes
- Colonnes représentant les différentes matières
- Filtrage par année, classe et filière

---

## 🧭 Fonctionnalités prévues

### 🧾 Bulletins scolaires
- Génération automatique des bulletins
- Moyennes générales et par matière
- Mentions, appréciations, classement
- Export PDF

### 💰 Paiements
- Gestion des frais de scolarité par mois
- Historique de paiement par élève
- Intégration des paiements mobiles (MoMo, Orange Money)

### 🔐 Authentification
- Accès sécurisé (admin, enseignant)
- Auth via cookie ou token JWT

### 🔄 Import/Export
- Import CSV (élèves, notes)
- Export des données (PDF, CSV)

### 📈 Dashboard
- Statistiques générales :
  - Nombre d’élèves
  - Répartition par genre, filière, classe
  - Top élèves
  - Évolution des inscriptions

### 🔎 Recherche et pagination
- Recherche instantanée dans toutes les tables
- Tri par colonnes (nom, note…)
- Pagination dynamique

### 🔌 API REST complète
- Endpoints :
  - `/eleves`, `/notes`, `/classes`, `/annees`, `/options`, etc.
- Requêtes `GET`, `POST`, `PUT`, `DELETE`
- Sécurité basique intégrée
- Documentation prévue (OpenAPI / Swagger)

---

## ⚙️ Installation

### 🧩 Prérequis
- PHP ≥ 7.4
- MySQL / MariaDB
- Serveur local : XAMPP, WAMP, MAMP, ou équivalent
- Navigateur moderne

### 📁 Arborescence
<pre lang="md"> ``` GestionScolaire/
  ├── frontend/ # Partie front (HTML/CSS/JS) 
  │ ├── dashboard/ # Tableau de bord admin 
  │ │ ├── dashboard.html 
  │ │ ├── dashboard.css 
  │ │ └── dashboard.js 
  │ ├── inscription/   # Formulaire d’inscription des élèves 
  │ │ ├── inscription.html 
  │ │ ├── inscription.css 
  │ │ └── inscription.js 
  │ ├── students/   # Liste filtrable des élèves 
  │ │ ├── students.html 
  │ │ ├── students.css 
  │ │ └── students.js 
  │ ├── notes/   # Liste des notes par élève 
  │ │ ├── notes.html 
  │ │ ├── notes.css 
  │ │ └── notes.js 
  │ └── assets/                                    # Fichiers statiques (icônes, images) 
  ├── backend/                                     # Partie serveur (API PHP) 
  │ ├── api/ # Routes API REST 
  │ │ ├── eleves/ # CRUD élèves 
  │ │ │ ├── list.php 
  │ │ │ ├── add.php 
  │ │ | ├── update.php
  │ │ │ └── delete.php
  │ │ ├── classes/ # CRUD classes 
  │ │ │ ├── list.php 
  │ │ │ ├── add.php 
  │ │ | ├── update.php
  │ │ │ └── delete.php
  │ │ ├── options/ # CRUD filières 
  │ │ │ ├── list.php 
  │ │ │ ├── add.php 
  │ │ | ├── update.php
  │ │ │ └── delete.php
  │ │ └── notes/ # CRUD notes 
  │ │ │ ├── list.php 
  │ │ │ ├── add.php 
  │ │ | ├── update.php
  │ │ │ └── delete.php
  │ │ ├── config/                                 # Fichier de connexion DB 
  │ │ | └── db.php 
  │ │ ├── models/ # Modèles PHP orientés objet 
  │ │ | ├── Eleve.php 
  │ │ | ├── Classe.php 
  │ │ | ├── Filiere.php 
  │ │ | ├── Note.php
  │ │ | ├── Bulletin.php
  │ │ | ├── Coef.php
  │ │ | ├── Matiere.php
  │ │ | └── Annee.php
  │ │ │ ├── utils/                               # Outils divers (auth, helpers) 
  │ │ | └── auth.php 
   ``` </pre>
  


### 🚀 Étapes
1. Cloner le dépôt :  
   `git clone https://github.com/ton-utilisateur/GestionScolaire.git`

2. Créer une base de données :  
   `gestionscolaire`

3. Importer le fichier SQL :  
   `backend/database.sql` via phpMyAdmin ou MySQL CLI

4. Configurer le fichier `config/db.php` si nécessaire

5. Lancer un serveur local et accéder à :  
   `http://localhost/GestionScolaire/frontend/`

---
## 🙋‍♂️ Auteur

**Souleymane Diallo**   
Développeur web junior — passionné par l’informatique éducative, la finance quantitative et l’IA.  
📫 aw5041591@gmail.com

---

## 📜 Licence

Projet open-source — libre de modification et d’utilisation à des fins pédagogiques.

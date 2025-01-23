<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Etudiant extends Users {

    // Constructeur
    public function __construct($f_name = null, $l_name = null, $email = null, $pwd_hashed = null, $roles = null, $birth_day = null, $created_at = null) {
        parent::__construct($f_name, $l_name, $email, $pwd_hashed, $roles, $birth_day, $created_at);
    }

    public function displayCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            // Préparation de la requête SQL
            $stmt = $conn->prepare("SELECT cours.*, users.*, cours_etudiant.*
                                    FROM cours
                                    JOIN users ON cours.users_id = users.users_id
                                    JOIN cours_etudiant ON cours_etudiant.etudiant = users.users_id
                                    WHERE cours_etudiant.etudiant = ?");
            $stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();

            // Récupération des résultats
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

}
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Category.php';


class Cours {
    protected $cours_id, $title, $descriptions, $containt, $created_at, $enseignant, $category;

    public function __construct($cours_id = null, $title = null, $descriptions = null, $containt = null, $created_at = null, $enseignant = null, $category = null) {
        $this->cours_id = $cours_id;
        $this->title = $title;
        $this->descriptions = $descriptions;
        $this->containt = $containt;
        $this->created_at = $created_at;
        $this->enseignant = $enseignant;
        $this->category = $category;
    }

    // Accesseurs (Getters)
    public function getCoursId() { return $this->cours_id; }
    public function getTitle() { return $this->title; }
    public function getDescriptions() { return $this->descriptions; }
    public function getContaint() { return $this->containt; }
    public function getCreatedAt() { return $this->created_at; }
    public function getEnseignant() { return $this->enseignant; }
    public function getCategory() { return $this->category; }

    // Modificateurs (Setters)
    public function setCoursId($cours_id) { $this->cours_id = $cours_id; }
    public function setTitle($title) { $this->title = $title; }
    public function setDescriptions($descriptions) { $this->descriptions = $descriptions; }
    public function setContaint($containt) { $this->containt = $containt; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setEnseignant($enseignant) { $this->enseignant = $enseignant; }
    public function setCategory($category) { $this->category = $category; }

    // Methodes
    public function getCategoryId() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT category_id FROM category WHERE category_name = ?");
            $stmt->execute([$this->category]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['category_id'] : false;
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function addCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $cat_id = $this->getCategoryId();
            
            $stmt = $conn->prepare("INSERT INTO cours (title, descriptions, contenu, created_at, enseignant, category)
                                    VALUES (?, ?, ?, NOW(), ?, ?)");
            $stmt->bindParam(1, $this->title, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->descriptions, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->containt, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->enseignant, PDO::PARAM_INT);
            $stmt->bindParam(5, $cat_id, PDO::PARAM_INT);
        
            $result = $stmt->execute();
        
            if ($result) {
                echo "<script>alert('Cours ajouté avec succès.')</script>";
                return true;
            } else {
                throw new Exception("Erreur lors de l'ajout du cours.");
            }
        } catch (Exception $e) {
            echo "<script>alert('Erreur : " . addslashes($e->getMessage()) . "');</script>";
            return false;
        } finally {
            $db->closeConnection();
        }
    }
    
    public function displayCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            // Si l'utilisateur est un admin, afficher tous les cours non supprimés
            if ($_SESSION['role'] === 'admin') {
                $stmt = $conn->prepare("SELECT cours.*, users.f_name, users.l_name, category.category_name 
                                        FROM cours
                                        JOIN users ON cours.enseignant = users.users_id
                                        JOIN category ON cours.category = category.category_id
                                        WHERE cours.is_deleted = 0");
            } else {
                // Sinon, afficher les cours non supprimés pour l'enseignant connecté
                $stmt = $conn->prepare("SELECT cours.*, users.f_name, users.l_name, category.category_name 
                                        FROM cours
                                        JOIN users ON cours.enseignant = users.users_id
                                        JOIN category ON cours.category = category.category_id
                                        WHERE cours.enseignant = :id AND cours.is_deleted = 0");
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function displayCoursByUser() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            if ($_SESSION['role'] === 'enseignant') {
                // Logique pour les enseignants : afficher leurs cours non supprimés
                $stmt = $conn->prepare("SELECT cours.*, users.f_name, users.l_name, category.category_name 
                                        FROM cours
                                        JOIN users ON cours.enseignant = users.users_id
                                        JOIN category ON cours.category = category.category_id
                                        WHERE cours.enseignant = :id AND cours.is_deleted = 0");
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            } elseif ($_SESSION['role'] === 'etudiant') {
                // Logique pour les étudiants : afficher les cours auxquels ils sont inscrits
                $stmt = $conn->prepare("SELECT cours.*, users.f_name, users.l_name, category.category_name 
                                        FROM cours_etudiant
                                        JOIN cours ON cours_etudiant.cours = cours.cours_id
                                        JOIN users ON cours.enseignant = users.users_id
                                        JOIN category ON cours.category = category.category_id
                                        WHERE cours_etudiant.etudiant = :id AND cours.is_deleted = 0");
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            } elseif ($_SESSION['role'] === 'admin') {
                // Logique pour les admins : rediriger vers une page d'erreur ou afficher tous les cours
                header('location: /Views/401.php');
                exit;
            } else {
                throw new Exception("Rôle utilisateur non reconnu.");
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function displayNonDeletedCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT cours.*, users.f_name, users.l_name FROM cours
                                    JOIN users ON cours.enseignant = users.users_id
                                    WHERE cours.enseignant = :id AND cours.is_deleted = 0");
            $stmt->bindParam(':id', $_SESSION['id']);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function subscribe() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            // Vérifier si l'étudiant est déjà inscrit à ce cours
            $stmt = $conn->prepare("SELECT * FROM cours_etudiant WHERE cours = :cours_id AND etudiant = :etudiant_id");
            $stmt->bindParam(':cours_id', $this->cours_id, PDO::PARAM_INT);
            $stmt->bindParam(':etudiant_id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception("Vous êtes déjà inscrit à ce cours.");
            }
    
            // Récupérer l'ID de l'enseignant associé au cours
            $stmt = $conn->prepare("SELECT enseignant FROM cours WHERE cours_id = :cours_id");
            $stmt->bindParam(':cours_id', $this->cours_id, PDO::PARAM_INT);
            $stmt->execute();
            $enseignant = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$enseignant) {
                throw new Exception("Enseignant non trouvé pour ce cours.");
            }
    
            // Insérer l'inscription dans la table cours_etudiant
            $stmt = $conn->prepare("INSERT INTO cours_etudiant (cours, etudiant, enseignant) VALUES (:cours_id, :etudiant_id, :enseignant_id)");
            $stmt->bindParam(':cours_id', $this->cours_id, PDO::PARAM_INT);
            $stmt->bindParam(':etudiant_id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->bindParam(':enseignant_id', $enseignant['enseignant'], PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Erreur lors de l'inscription au cours.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function deleteCours(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $cours_id = $this->getCoursId();
            if ($cours_id === null) {
                throw new Exception("L'ID du cours est manquant.");
            }
    
            $stmt = $conn->prepare("UPDATE cours SET is_deleted = 1 WHERE cours_id = :id");
            $stmt->bindParam(":id", $cours_id, PDO::PARAM_INT);
            $result = $stmt->execute();
    
            if ($result) {
                return true;
            } else {
                throw new Exception("Erreur lors de la suppression du cours.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }
    
    public function updateCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $cours_id = $this->getCoursId();
            if ($cours_id === null) {
                throw new Exception("L'ID du cours est manquant.");
            }
    
            // Préparer la requête SQL pour mettre à jour les champs
            $stmt = $conn->prepare("UPDATE cours SET title = ?, descriptions = ?, contenu = ?, enseignant = ?, category = ? WHERE cours_id = ?");
            $stmt->bindParam(1, $this->title, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->descriptions, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->containt, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->enseignant, PDO::PARAM_INT);
            $stmt->bindParam(5, $this->category, PDO::PARAM_INT);
            $stmt->bindParam(6, $cours_id, PDO::PARAM_INT);
    
            $result = $stmt->execute();
    
            if ($result) {
                return true;
            } else {
                throw new Exception("Erreur lors de la mise à jour du cours.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function getNombreInscrits($cours_id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT COUNT(etudiant) AS nombre_etudiants 
                                    FROM cours_etudiant 
                                    WHERE cours = ?");
            $stmt->bindParam(1, $cours_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result ? $result['nombre_etudiants'] : 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function getInscriptionStats() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT c.title, COUNT(ce.etudiant) AS nombre_inscriptions
                                    FROM cours_etudiant ce
                                    JOIN cours c ON ce.cours = c.cours_id
                                    WHERE c.is_deleted = 0
                                    GROUP BY ce.cours
                                    ORDER BY nombre_inscriptions DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des statistiques : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function endCours(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            // Préparation de la requête SQL
            $stmt = $conn->prepare("UPDATE TABLE cours_etudiant SET is_terminer = 1 WHERE etudiant = ? AND cours = ?");
            $stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $this->getCoursId(), PDO::PARAM_INT);
            $result =  $stmt->execute();

            return $result;

        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }
    
    public function populareCours() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT c.cours_id, c.title, c.is_deleted, COUNT(ce.etudiant) AS nombre_etudiants 
                                    FROM cours_etudiant ce
                                    JOIN cours c ON ce.cours = c.cours_id
                                    WHERE is_deleted = 0
                                    GROUP BY ce.cours 
                                    ORDER BY nombre_etudiants DESC 
                                    LIMIT 1;");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result ? [$result] : [];
    
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }
}
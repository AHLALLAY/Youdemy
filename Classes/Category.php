<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Category {
    protected $category_name;
    protected $type; // Pour distinguer entre catégorie et tag
    protected $category_id; // Pour l'édition des catégories
    protected $tag_id; // Pour l'édition des tags

    // Constructeur
    public function __construct($category_name = null, $type = null) {
        $this->category_name = $category_name;
        $this->type = $type;
    }

    // Accesseurs (Getters)
    public function getCategoryName() { return $this->category_name; }
    public function getType() { return $this->type; }
    public function getCategoryId() { return $this->category_id; }
    public function getTagId() { return $this->tag_id; }

    // Modificateurs (Setters)
    public function setCategoryName($category_name) { $this->category_name = $category_name; }
    public function setType($type) { $this->type = $type; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; }
    public function setTagId($tag_id) { $this->tag_id = $tag_id; }

    // Méthode pour vérifier si une catégorie ou un tag existe déjà
    public function isExist() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $table = ($this->type === 'tag') ? 'tags' : 'category'; // Choisir la table en fonction du type
            $stmt = $conn->prepare("SELECT name FROM $table WHERE name = ?");
            $stmt->bindParam(1, $this->category_name, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour ajouter une catégorie ou un tag
    public function addCategory() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            if (!$this->isExist()) {
                $table = ($this->type === 'tag') ? 'tags' : 'category';
                if ($table == 'tags') {
                    $stmt = $conn->prepare("INSERT INTO tags (tag_name) VALUES (:name)");
                } else {
                    $stmt = $conn->prepare("INSERT INTO category (category_name) VALUES (:name)");
                }

                $stmt->bindParam(':name', $this->category_name);
                $result = $stmt->execute();

                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false; // La catégorie ou le tag existe déjà
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour afficher les catégories ou les tags
    public function display($type = null) {
        $db = new Connection();
        $conn = $db->getConnection();

        try {
            if ($type === null) {
                // Récupérer à la fois les catégories et les tags
                $stmtCategories = $conn->prepare("SELECT * FROM category");
                $stmtCategories->execute();
                $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

                $stmtTags = $conn->prepare("SELECT * FROM tags");
                $stmtTags->execute();
                $tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);

                // Combiner les résultats
                return [
                    'categories' => $categories ?: [],
                    'tags' => $tags ?: []
                ];
            } else {
                // Récupérer uniquement les catégories ou les tags en fonction de $type
                $table = ($type === 'tag') ? 'tags' : 'category';
                $stmt = $conn->prepare("SELECT * FROM $table");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result ?: [];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ($type === null) ? ['categories' => [], 'tags' => []] : [];
        } finally {
            $conn = null;
        }
    }

    // Méthode pour récupérer une catégorie par son ID
    public function getCategoryById($category_id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
            $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour récupérer un tag par son ID
    public function getTagById($tag_id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM tags WHERE tag_id = ?");
            $stmt->bindParam(1, $tag_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour mettre à jour une catégorie
    public function updateCategory() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("UPDATE category SET category_name = ? WHERE category_id = ?");
            $stmt->bindParam(1, $this->category_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->category_id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour mettre à jour un tag
    public function updateTag() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("UPDATE tags SET tag_name = ? WHERE tag_id = ?");
            $stmt->bindParam(1, $this->category_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->tag_id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour supprimer une catégorie
    public function deleteCategory($category_id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("DELETE FROM category WHERE category_id = ?");
            $stmt->bindParam(1, $category_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        } finally {
            $db->closeConnection();
        }
    }

    // Méthode pour supprimer un tag
    public function deleteTag($tag_id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("DELETE FROM tags WHERE tag_id = ?");
            $stmt->bindParam(1, $tag_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        } finally {
            $db->closeConnection();
        }
    }

}
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Category{
    protected $category_name;
    
    // construct
    public function __construct($category_name=null){
        $this->category_name = $category_name;
    }

    // Accesseur (Getters)
    public function getCategoryName(){return $this->category_name;}

    // Modificateur (Setters)
    public function setCategoryName($category_name){$this->category_name = $category_name;}

    // Methodes
    public function isExist(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT category_name FROM category WHERE category_name = ?");
            $stmt->bindParam(1, $this->category_name, PDO::PARAM_STR);
            $stmt->execute();
    

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        } finally {
            $db->closeConnection();
        }
    }
    public function addCategory(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            if (!$this->isExist()) {
                $stmt = $conn->prepare("INSERT INTO category (category_name) VALUES (:category_name)");
                $stmt->bindParam(':category_name', $this->category_name);
                $result = $stmt->execute();
    
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        } finally {
            $db->closeConnection();
        }
    }

    
}
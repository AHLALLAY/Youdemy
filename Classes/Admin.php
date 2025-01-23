<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Admin extends Users{
    // Constructeur
    public function __construct($f_name=null, $l_name=null, $email=null, $pwd_hashed=null, $roles=null, $birth_day=null, $created_at=null){
        parent::__construct($f_name, $l_name, $email, $pwd_hashed, $roles, $birth_day, $created_at);
    }

    public function toggleSuspension(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            
            $stmt = $conn->prepare("UPDATE users SET is_suspended = 1 - is_suspended WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error in toggleSuspension: " . $e->getMessage());
            return false;
        } finally {
            $db->closeConnection();
        }
    }
    
    public function isSuspended(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT is_suspended FROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return (bool)$result['is_suspended'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }finally{
            $db->closeConnection();
        }
    }

    public function deleteUsers(){
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT is_deleted FROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && $result['is_deleted'] == 0) {
                $stmt = $conn->prepare("UPDATE users SET is_deleted = 1 WHERE email = :email");
                $stmt->bindParam(":email", $this->email);
                $stmt->execute();
    
                // Optionnel : Supprimer physiquement l'utilisateur (hard delete)
                // $stmt = $conn->prepare("DELETE FROM users WHERE email = :email");
                // $stmt->bindParam(":email", $this->email);
                // $stmt->execute();
    
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error in deleteUsers: " . $e->getMessage();
        } finally {
            $db->getConnection();
        }
    }

}
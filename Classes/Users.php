<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Users {
    protected $f_name;
    protected $l_name;
    protected $email;
    protected $pwd_hashed;
    protected $roles;
    protected $created_at;

    public function __construct($f_name = null, $l_name = null, $email = null, $pwd_hashed = null, $roles = null) {
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->email = $email;
        $this->pwd_hashed = $pwd_hashed;
        $this->roles = $roles;
    }

    // Accesseurs (Getters)
    public function getFName() { return $this->f_name; }
    public function getLName() { return $this->l_name; }
    public function getEmail() { return $this->email; }
    public function getRoles() { return $this->roles; }

    // Modificateurs (Setters)
    public function setFName($f_name) { $this->f_name = $f_name; }
    public function setLName($l_name) { $this->l_name = $l_name; }
    public function setEmail($email) { $this->email = $email; }
    public function setPwd($pwd_hashed) { $this->pwd_hashed = $pwd_hashed; }
    public function setRoles($roles) { $this->roles = $roles; }

    // Méthodes
    public function isExist($email = null) {
        if (empty($email)) {
            throw new Exception("Email is required.");
        }

        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return "Error : " . $e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function login() {
        ob_start(); // Démarre la temporisation de sortie pour éviter les erreurs d'en-têtes
    
        if (empty($this->email) || empty($this->pwd_hashed)) {
            throw new Exception("Email and password are required.");
        }
    
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            // Récupérer l'utilisateur
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$this->email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$user) {
                throw new Exception("No user found with this email.");
            }
    
            // Vérifier si l'utilisateur est suspendu
            if ($user['is_suspended']) {
                var_dump($user['is_suspended']); // Debug
                header('Location: /Views/401.php');
                exit;
            }
    
            // Vérifier si l'utilisateur est supprimé
            if ($user['is_deleted']) {
                header('Location: /Views/403.php');
                exit;
            }
    
            // Vérifier le mot de passe
            if (!password_verify($this->pwd_hashed, $user['pwd_hashed'])) {
                throw new Exception("Email or password incorrect.");
            }
    
            // Retourner les informations de l'utilisateur
            return $user;
    
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('location: Login.php');
        exit;
    }

    public function register() {
        if (empty($this->f_name) || empty($this->l_name) || empty($this->email) || empty($this->pwd_hashed)) {
            throw new Exception("All fields are required.");
        }

        if ($this->isExist($this->email)) {
            throw new Exception("Email already exists.");
        }

        $this->pwd_hashed = password_hash($this->pwd_hashed, PASSWORD_DEFAULT);

        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("INSERT INTO users (f_name, l_name, email, pwd_hashed, roles) VALUES (:f_name, :l_name, :email, :pwd_hashed, :roles)");
            $stmt->bindParam(':f_name', $this->f_name);
            $stmt->bindParam(':l_name', $this->l_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':pwd_hashed', $this->pwd_hashed);
            $stmt->bindParam(':roles', $this->roles);
            $result = $stmt->execute();
            if($result){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            return "Error :" . $e->getMessage();
        }finally{
            $db->closeConnection();
        }
        return true;
    }

    public function getUsers(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }else{
                return "No User";
            }

        }catch(PDOException $e){
            echo "Error" . $e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function getEtudiant(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM users WHERE roles = 'etudiant'");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }else{
                return [];
            }

        }catch(PDOException $e){
            echo "Error" . $e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function getEnseignant() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
    
            $stmt = $conn->prepare("SELECT * FROM users WHERE roles = 'enseignant'");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: [];
    
        } catch(PDOException $e) {
            echo "Error : " . $e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function suspendsStatus(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT is_suspended FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        }catch(PDOException $e){
            echo "Error : ".$e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function Suspend(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT*FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$result['is_suspended']){
                $stmt = $conn->prepare("UPDATE users SET is_suspended = 1 WHERE email = :email");
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
            }
            
        }catch(PDOException $e){
            echo "Error : ".$e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function Activate(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT*FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($result['is_suspended']){
                $stmt = $conn->prepare("UPDATE users SET is_suspended = 0 WHERE email = :email");
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
            }
            
        }catch(PDOException $e){
            echo "Error : ".$e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function deleteUser(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT*FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$result['is_deleted']){
                $stmt = $conn->prepare("UPDATE users SET is_deleted = 1 WHERE email = :email");
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
            }
            
        }catch(PDOException $e){
            echo "Error : ".$e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }

    public function deleteStats(){
        try{
            $db = new Connection();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT*FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['is_deleted'];
            
        }catch(PDOException $e){
            echo "Error : ".$e->getMessage();
        }finally{
            $db->closeConnection();
        }
    }
}
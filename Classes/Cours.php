<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';

class Cours{
    protected $title, $descriptions, $containt, $created_at, $enseignant, $category;

    public function __construct($title, $descriptions, $containt, $created_at, $enseignant, $category){
        $this->title = $title;
        $this->descriptions = $descriptions;
        $this->containt = $containt;
        $this->created_at = $created_at;
        $this->enseignant = $enseignant;
        $this->category = $category;
    }

    // Accesseur (Getters)
    public function getTitle(){return $this->title;}
    public function getDescriptions(){return $this->descriptions;}
    public function getContaint(){return $this->containt;}
    public function getCreatedAt(){return $this->created_at;}
    public function getEnseignant(){return $this->enseignant;}
    public function getCategory(){return $this->category;}

    // Modificateur (Setters)
    public function setTitle($title){$this->title = $title;}
    public function setDescriptions($descriptions){$this->descriptions = $descriptions;}
    public function setContaint($containt){$this->containt = $containt;}
    public function setCreatedAt($created_at){return $this->created_at = $created_at;}
    public function setEnseignant($enseignant){return $this->enseignant = $enseignant;}
    public function setCategiry($category){$this->category = $category;}

    public function addCours(){
        $db = new Connection("localhost","root","","youdemy");
        $conn = $db->getConnection();
        try{
            $stmt = $conn->prepare("INSERT INTO cours(title, descriptions, contenu, created_at, user_id, category_id)
                                                VALUES(?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->title, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->descriptions, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->containt, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->created_at, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->enseignant, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->category, PDO::PARAM_STR);

            $result = $stmt->execute();
            if($result){
                echo "<script>alert('cours added')</script>";
            }else{
                echo "<script>alert('added failed')</script>";
            }
        }catch(PDOException $e){
            throw new Exception("Error") .$e->getMessage();
        }finally{
            $conn = null;
        }
    }

    public function displayCours(){

    }
}
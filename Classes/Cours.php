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


}
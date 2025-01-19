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
    
}
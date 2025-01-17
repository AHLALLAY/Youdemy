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
    public function setPwd($pwd_hashed) { $this->pwd_hashed = $pwd_hashed; }
    public function setRoles($roles) { $this->roles = $roles; }


}
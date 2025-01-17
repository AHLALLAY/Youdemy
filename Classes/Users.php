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


}
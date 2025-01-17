<?php
class Connection {
    protected $host;
    protected $username;
    protected $password;
    protected $database;
    protected $conn;

    public function __construct($host = "localhost", $username = "root", $password = "", $database = "youdemy") {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->conn = null;
    }

    public function getConnection() {
        try {
            if ($this->conn === null) {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $this->conn;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la connexion à la base de données : " . $e->getMessage());
        }
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
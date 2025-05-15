<?php
class Database
{
    private $host     = 'localhost:3309';
    private $username = 'root';
    private $password = '';
    private $db_name  = 'dreamabode';
    public $conn;

    public function connection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }

}

define('EMAIL_USERNAME', 'thisathgeemal38@gmail.com');
define('EMAIL_PASSWORD', 'uxbu kulx ntvv vbib');

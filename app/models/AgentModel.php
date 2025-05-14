<?php
class Agent
{
    private $table = "agent";

    public $username;
    public $password;
    public $email;
    public $mobile;
    public $dob;
    public $gender;
    public $image;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            unset($user['Password']);
            return $user;
        }

        return false;
    }
}

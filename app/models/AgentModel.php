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

    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($email, $newPassword)
    {
        $query = "UPDATE " . $this->table . " SET Password = :password WHERE Email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', password_hash($newPassword, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        return $stmt->execute();
    }
}

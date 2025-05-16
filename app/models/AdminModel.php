<?php
class Admin
{
    private $table = "admin";

    public $username;
    public $password;
    public $email;
    public $mobile;
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
        $queryUser = "SELECT UserName FROM " . $this->table . " WHERE Email = :email";
        $stmtUser  = $this->conn->prepare($queryUser);
        $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if (! $user) {
            return false;
        }
        $query = "UPDATE " . $this->table . " SET Password = :password WHERE Email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', password_hash($newPassword, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['username'] = $user['UserName'];
            return true;
        }
        return false;
    }

    public function getUserProfile($userId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE ID = :userId LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}

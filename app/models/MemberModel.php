<?php
class Member
{
    private $table = "member";

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

    public function isUsernameExists()
    {
        $query = "SELECT 1 FROM " . $this->table . " WHERE Username = :username LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function isEmailExists()
    {
        $query = "SELECT 1 FROM " . $this->table . " WHERE Email = :email LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function signup()
    {
        $query = "INSERT INTO " . $this->table . "(Username, Password, Email, MobileNumber, created_at) VALUES (:username, :password, :email, :mobile, NOW())";

        $stmt = $this->conn->prepare($query);

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mobile', $this->mobile);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        return false;
    }
}

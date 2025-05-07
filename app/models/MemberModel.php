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

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function signup()
    {
        $query = "INSERT INTO " . $this->table . "(Username, Password, Email, Mobile, created_at) VALUES (:username, :password, :email, :mobile, NOW())";

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
}

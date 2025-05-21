<?php
class Member
{
    private $table = "member";

    public $id;
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
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
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
        }
        return false;

    }

    public function updateMember()
    {
        $query = "UPDATE " . $this->table . " SET Username = :username, Email = :email, MobileNumber = :mobile, DOB = :dob, Gender = :gender";

        if (! empty($this->password)) {
            $query .= ", Password = :password";
        }

        if (! empty($this->image)) {
            $query .= ", Image = :image";
        }

        $query .= " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':dob', $this->dob);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':id', $this->id);

        if (! empty($this->password)) {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        if (! empty($this->image)) {
            $stmt->bindParam(':image', $this->image, PDO::PARAM_LOB);
        }

        return $stmt->execute();
    }

    public function getAllMembers()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at ASC";
        $stmt  = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function removeMembersById($userId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE ID = :userId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function memberCount()
    {
        try {
            $query = "SELECT COUNT(*) as Count FROM " . $this->table;
            $stmt  = $this->conn->prepare($query);
            $stmt->execute();

            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
}

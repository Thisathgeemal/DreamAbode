<?php
require_once '../../models/MemberModel.php';

class MemberController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function signupMember()
    {
        $massage = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username        = $_POST['username'];
            $email           = $_POST['email'];
            $mobile          = $_POST['mobile'];
            $password        = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'Invalid email format!';
            }

            if (! preg_match('/^[0-9]{10}$/', $mobile)) {
                return 'Invalid mobile number!';
            }

            if ($password !== $confirmPassword) {
                $massage = 'Passwords do not match!';
            } else {
                $member           = new Member($this->conn);
                $member->username = $username;
                $member->password = $password;
                $member->email    = $email;
                $member->mobile   = $mobile;

                if ($member->signup()) {
                    $massage = "Member registered successfully!";
                } else {
                    $massage = "Member registration failed.";
                }
            }
        }

        return $massage;
    }
}

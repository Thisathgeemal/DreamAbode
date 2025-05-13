<?php
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../../config/database.php';

class MemberController
{
    private $conn;
    private $member;

    public function __construct()
    {
        $database     = new Database();
        $this->conn   = $database->connection();
        $this->member = new Member($this->conn);
    }

    public function signupMember()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username        = trim($_POST['username']);
            $email           = trim($_POST['email']);
            $mobile          = trim($_POST['mobile']);
            $password        = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);

            $this->member->username = $username;
            $this->member->password = $password;
            $this->member->email    = $email;
            $this->member->mobile   = $mobile;

            $_SESSION['form_data'] = [
                'username'        => $username,
                'email'           => $email,
                'mobile'          => $mobile,
                'password'        => $password,
                'confirmPassword' => $confirmPassword,
            ];

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg']      = "Invalid email format!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif (! preg_match('/^[0-9]{10}$/', $mobile)) {
                $_SESSION['msg']      = "Invalid mobile number!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($password !== $confirmPassword) {
                $_SESSION['msg']      = "Passwords do not match!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isUsernameExists() && $this->member->isEmailExists()) {
                $_SESSION['msg']      = "Username and email already exist!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isUsernameExists()) {
                $_SESSION['msg']      = "Username already exists!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isEmailExists()) {
                $_SESSION['msg']      = "Email already exists!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } else {
                if ($this->member->signup()) {
                    $_SESSION['msg']      = "Member registered successfully!";
                    $_SESSION['redirect'] = "/DreamAbode/public/login";
                    unset($_SESSION['form_data']);
                } else {
                    $_SESSION['msg']      = "Member registration failed.";
                    $_SESSION['redirect'] = "/DreamAbode/public/registration";
                }
            }
        }

        require_once __DIR__ . '/../views/pages/registration.php';
        exit();

    }
}

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
                $_SESSION['message']  = "Invalid email format!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif (! preg_match('/^[0-9]{10}$/', $mobile)) {
                $_SESSION['message']  = "Invalid mobile number!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($password !== $confirmPassword) {
                $_SESSION['message']  = "Passwords do not match!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isUsernameExists() && $this->member->isEmailExists()) {
                $_SESSION['message']  = "Username and email already exist!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isUsernameExists()) {
                $_SESSION['message']  = "Username already exists!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } elseif ($this->member->isEmailExists()) {
                $_SESSION['message']  = "Email already exists!";
                $_SESSION['redirect'] = "/DreamAbode/public/registration";
            } else {
                try {
                    if ($this->member->signup()) {
                        $_SESSION['message']  = "Member registered successfully!";
                        $_SESSION['redirect'] = "/DreamAbode/public/login";
                        unset($_SESSION['form_data']);
                    } else {
                        $_SESSION['message']  = "Member registration failed. Please try again.";
                        $_SESSION['redirect'] = "/DreamAbode/public/registration";
                    }
                } catch (PDOException $e) {
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        if (strpos($e->getMessage(), 'MobileNumber') !== false) {
                            $_SESSION['message'] = "Mobile number already registered!";
                        } elseif (strpos($e->getMessage(), 'Email') !== false) {
                            $_SESSION['message'] = "Email address already registered!";
                        } else {
                            $_SESSION['message'] = "A duplicate entry was detected!";
                        }
                    } else {
                        $_SESSION['message'] = "An error occurred during registration. Please try again.";
                    }
                    $_SESSION['redirect'] = "/DreamAbode/public/registration";
                }
            }
        }

        require_once __DIR__ . '/../views/pages/registration.php';
        exit();
    }

}

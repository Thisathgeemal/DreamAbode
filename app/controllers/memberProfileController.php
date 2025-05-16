<?php
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/AgentModel.php';
require_once __DIR__ . '/../../config/database.php';

class MemberProfileController
{
    private $conn;
    private $member;
    private $admin;
    private $agent;

    public function __construct()
    {
        $database     = new Database();
        $this->conn   = $database->connection();
        $this->member = new Member($this->conn);
        $this->admin  = new Admin($this->conn);
        $this->agent  = new Agent($this->conn);
    }

    public function index()
    {
        session_start();
        if (! isset($_SESSION['user_id']) || ! isset($_SESSION['user_role'])) {
            header("Location: /DreamAbode/public/login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $type   = $_SESSION['user_role'];

        switch ($type) {
            case 'member':
                $userData = $this->member->getUserProfile($userId);
                break;

            case 'admin':
                $userData = $this->admin->getUserProfile($userId);
                break;

            case 'agent':
                $userData = $this->agent->getUserProfile($userId);
                break;

            default:
                header("Location: /DreamAbode/public/login");
                exit();
        }

        if ($userData) {
            require_once '../app/views/dashboard/memberProfile.php';
        }
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

    public function updateProfile()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $userId   = $_SESSION['user_id'];
            $userType = $_SESSION['user_role'];

            if (! $userId || ! $userType) {
                $_SESSION['error'] = "Session expired or unauthorized access.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            $this->member->id       = $userId;
            $this->member->username = trim($_POST['username']);
            $this->member->email    = trim($_POST['email']);
            $this->member->mobile   = trim($_POST['mobile']);
            $this->member->dob      = trim($_POST['dob']);
            $this->member->gender   = trim($_POST['gender']);
            $this->member->password = trim($_POST['password']);
            $this->member->image    = '';

            // Handle optional image upload
            if (! empty($_FILES['image']['name'])) {
                $uploadDir  = 'uploads/';
                $imageName  = basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $this->member->image = $imageName;
                }
            }

            switch ($userType) {
                case 'member':
                    $this->member->updateMember();
                    $_SESSION['message']  = "Profile updated successfully!";
                    $_SESSION['redirect'] = "/DreamAbode/public/memberProfile";
                    break;

                case 'admin':
                    $this->admin->updateAdmin();
                    $_SESSION['message']  = "Profile updated successfully!";
                    $_SESSION['redirect'] = "/DreamAbode/public/adminProfile";
                    break;

                case 'agent':
                    $this->agent->updateAgent();
                    $_SESSION['message']  = "Profile updated successfully!";
                    $_SESSION['redirect'] = "/DreamAbode/public/agentProfile";
                    break;

                default:
                    $_SESSION['error']    = "Invalid user type.";
                    $_SESSION['redirect'] = "/DreamAbode/public/login";
            }

            header("Location: " . $_SESSION['redirect']);
            exit();
        }
    }

}

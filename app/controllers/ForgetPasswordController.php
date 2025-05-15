<?php
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/AgentModel.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../utils/mailHelper.php';

class ForgetPasswordController
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
        require_once '../app/views/pages/forgetPassword.php';
    }

    public function sendVerificationCode()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error']    = "Invalid email format.";
                $_SESSION['redirect'] = "/DreamAbode/public/forgetPassword";
                header("Location: " . $_SESSION['redirect']);
                exit();
            }

            $userType = '';
            $user     = $this->member->findByEmail($email);
            if ($user) {
                $userType = 'member';
            } else {
                $user = $this->admin->findByEmail($email);
                if ($user) {
                    $userType = 'admin';
                } else {
                    $user = $this->agent->findByEmail($email);
                    if ($user) {
                        $userType = 'agent';
                    }
                }
            }

            $_SESSION['user_type'] = $userType;

            if (! $user) {
                $_SESSION['error']    = "No user found with that email.";
                $_SESSION['redirect'] = "/DreamAbode/public/forgetPassword";
                header("Location: " . $_SESSION['redirect']);
                exit();
            }

            $verificationCode                   = rand(100000, 999999);
            $_SESSION['reset_email']            = $email;
            $_SESSION['verification_code']      = $verificationCode;
            $_SESSION['verification_code_time'] = time();

            sendVerificationEmail($email, $verificationCode);

            $_SESSION['success']  = "Verification code sent to your email successfully.";
            $_SESSION['redirect'] = "/DreamAbode/public/forgetPassword";
            header("Location: " . $_SESSION['redirect']);
            exit();
        }
    }

    public function resetForgotPassword()
    {
        session_start();
        unset($_SESSION['verification_code']);
        unset($_SESSION['verification_code_time']);
        unset($_SESSION['form_data']);
        $_SESSION['redirect'] = "/DreamAbode/public/login";
        header("Location: " . $_SESSION['redirect']);
        exit();
    }

    public function verifyCode()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
            $enteredCode = implode('', $_POST['code']);
            $storedCode  = isset($_SESSION['verification_code']) ? trim($_SESSION['verification_code']) : '';
            $codeTime    = isset($_SESSION['verification_code_time']) ? $_SESSION['verification_code_time'] : 0;

            $validityPeriod = 3 * 60;

            if ((time() - $codeTime) > $validityPeriod) {
                $_SESSION['error']    = "Verification code has expired. Please request a new one.";
                $_SESSION['redirect'] = "/DreamAbode/public/forgetPassword";

            } else if ($enteredCode === $storedCode) {
                $_SESSION['verified']      = true;
                $_SESSION['success']       = "Verification successful! You can reset your password.";
                $_SESSION['verifiedEmail'] = $_SESSION['reset_email'];

            } else {
                $_SESSION['error']    = "Invalid verification code.";
                $_SESSION['redirect'] = "/DreamAbode/public/forgetPassword";
            }
        } else {
            $_SESSION['redirect'] = "/DreamAbode/public/login";
        }

        header("Location: " . $_SESSION['redirect']);
        exit;
    }

    public function resetPassword()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email    = $_SESSION['verifiedEmail'] ?? null;
        $userType = $_SESSION['user_type'] ?? null;
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (! $email || ! $userType) {
            $_SESSION['error'] = "Session expired or invalid request.";
            header("Location: /DreamAbode/public/forgetPassword");
            exit;
        }

        if ($password !== $confirm) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: /DreamAbode/public/forgetPassword");
            exit;
        }

        switch ($userType) {
            case 'member':
                $this->member->updatePassword($email, $password);
                break;
            case 'admin':
                $this->admin->updatePassword($email, $password);
                break;
            case 'agent':
                $this->agent->updatePassword($email, $password);
                break;
            default:
                $_SESSION['error'] = "Invalid user type.";
                header("Location: /DreamAbode/public/forgetPassword");
                exit;
        }

        $_SESSION['success']  = "Password updated successfully.";
        $_SESSION['redirect'] = "/DreamAbode/public/login";
        header("Location: " . $_SESSION['redirect']);
        exit;
    }

}

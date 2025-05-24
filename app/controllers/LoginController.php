<?php
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/AgentModel.php';
require_once __DIR__ . '/../utils/CookieHelper.php';
require_once __DIR__ . '/../../config/database.php';

class LoginController
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
        require_once '../app/views/pages/login.php';
    }

    public function handleLogin($username, $password, $type, $remember)
    {
        session_start();
        $username = trim($username);
        $password = trim($password);

        $user     = false;
        $redirect = '';

        switch ($type) {
            case 'member':
                $user     = $this->member->login($username, $password);
                $redirect = '/DreamAbode/public/memberProfile';
                break;

            case 'admin':
                $user     = $this->admin->login($username, $password);
                $redirect = '/DreamAbode/public/adminProfile';
                break;

            case 'agent':
                $user     = $this->agent->login($username, $password);
                $redirect = '/DreamAbode/public/agentProfile';
                break;

            default:
                $_SESSION['message']  = "Invalid login type.";
                $_SESSION['redirect'] = "/DreamAbode/public/login";
                header("Location: " . $_SESSION['redirect']);
                exit();
        }

        if ($user) {
            if ($remember) {
                setSecureCookie('username', $username, time() + (7 * 24 * 60 * 60));
                setSecureCookie('password', $password, time() + (7 * 24 * 60 * 60));

            } else {
                clearSecureCookie('username');
                clearSecureCookie('password');
            }

            $_SESSION['user_id']   = $user["ID"];
            $_SESSION['username']  = $username;
            $_SESSION['user_role'] = $type;

            $_SESSION['message'] = "Login successfully!";
            header("Location: " . $redirect);
            exit();
        } else {
            $_SESSION['message']  = "Invalid username or password.";
            $_SESSION['redirect'] = "/DreamAbode/public/login";
            header("Location: " . $_SESSION['redirect']);
            exit();
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $type     = isset($_POST['login_type']) ? $_POST['login_type'] : '';
            $remember = isset($_POST['remember']) ? true : false;

            $this->handleLogin($username, $password, $type, $remember);
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /DreamAbode/public/login");
        exit();
    }

}

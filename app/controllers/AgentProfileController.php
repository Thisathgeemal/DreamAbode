<?php
require_once __DIR__ . '/../models/AgentModel.php';
require_once __DIR__ . '/../../config/database.php';

class AgentProfileController
{
    private $conn;

    private $agent;

    public function __construct()
    {
        $database    = new Database();
        $this->conn  = $database->connection();
        $this->agent = new Agent($this->conn);
    }

    public function index()
    {
        session_start();
        if (! isset($_SESSION['user_id'])) {
            header("Location: /DreamAbode/public/login");
            exit();
        }

        $userId   = $_SESSION['user_id'];
        $userData = $this->agent->getUserProfile($userId);

        require_once '../app/views/dashboard/agentProfile.php';
    }

    public function createAgent()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $mobile   = trim($_POST['mobile']);
            $password = trim($_POST['password']);
            $dob      = trim($_POST['dob']);
            $gender   = trim($_POST['gender']);

            // Set agent values
            $this->agent->username = $username;
            $this->agent->password = $password;
            $this->agent->email    = $email;
            $this->agent->mobile   = $mobile;
            $this->agent->dob      = $dob;
            $this->agent->gender   = $gender;

            // Basic validations
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg'] = "Invalid email format!";
            } elseif (! preg_match('/^[0-9]{10}$/', $mobile)) {
                $_SESSION['msg'] = "Invalid mobile number!";
            } else {

                if ($this->agent->isUsernameExists() && $this->agent->isEmailExists()) {
                    $_SESSION['msg'] = "Username and email already exist!";
                } elseif ($this->agent->isUsernameExists()) {
                    $_SESSION['msg'] = "Username already exists!";
                } elseif ($this->agent->isEmailExists()) {
                    $_SESSION['msg'] = "Email already exists!";
                } else {
                    if ($this->agent->addAgent()) {
                        $_SESSION['msg'] = "Agent created successfully!";
                    } else {
                        $_SESSION['error'] = "Failed to register agent. Please try again.";
                    }
                    header("Location: /DreamAbode/public/adminProfile?section=agents");
                    exit();
                }
            }

            header("Location: /DreamAbode/public/adminProfile?section=agents");
            exit();
        } else {
            header("Location: /DreamAbode/public/login");
            exit();
        }
    }

    public function deleteAgent()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ! empty($_POST['agent_ids'])) {
            $deleted = 0;
            foreach ($_POST['agent_ids'] as $userId) {
                if ($this->agent->removeAgentById($userId)) {
                    $deleted++;
                }
            }

            if ($deleted > 0) {
                $_SESSION['msg'] = "$deleted agent(s) deleted successfully!";
            } else {
                $_SESSION['msg'] = "No agents were deleted.";
            }
        } else {
            $_SESSION['msg'] = "No agents selected for deletion.";
        }

        header("Location: /DreamAbode/public/adminProfile?section=agents");
        exit();
    }

}

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
}

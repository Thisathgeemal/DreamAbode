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

}

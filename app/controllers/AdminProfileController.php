<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class AdminProfileController
{
    private $conn;
    private $admin;
    private $property;

    public function __construct()
    {
        $database       = new Database();
        $this->conn     = $database->connection();
        $this->admin    = new Admin($this->conn);
        $this->property = new Property($this->conn);
    }

    public function index()
    {
        session_start();
        if (! isset($_SESSION['user_id'])) {
            header("Location: /DreamAbode/public/login");
            exit();
        }

        $userId     = $_SESSION['user_id'];
        $userData   = $this->admin->getUserProfile($userId);
        $properties = $this->property->getAllPropertyRequest();

        require_once '../app/views/dashboard/adminProfile.php';
    }

}

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

        $userId             = $_SESSION['user_id'];
        $userData           = $this->admin->getUserProfile($userId);
        $pendingProperties  = $this->property->getAllPropertyRequest();
        $acceptedProperties = $this->property->getAcceptedProperties();
        $rejectedProperties = $this->property->getRejectedProperties();

        require_once '../app/views/dashboard/adminProfile.php';
    }

    public function handlePropertyRequest()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId     = $_SESSION['user_id'] ?? null;
            $propertyId = $_POST['property_id'] ?? null;
            $action     = $_POST['action'] ?? null;

            if (! $userId || ! $propertyId || ! $action) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            if ($action === 'Accept') {
                $result = $this->property->assignAgentAndAccept($propertyId, $userId);
                if ($result) {
                    $_SESSION['msg'] = "Property request accepted and agent assigned successfully.";
                } else {
                    $_SESSION['error'] = "Failed to accept property request.";
                }

            } elseif ($action === 'Reject') {
                $result = $this->property->rejectPropertyRequest($propertyId, $userId);
                if ($result) {
                    $_SESSION['msg'] = "Property request rejected successfully.";
                } else {
                    $_SESSION['error'] = "Failed to reject property request.";
                }

            } else {
                $_SESSION['error'] = "Invalid action.";
            }

            header("Location: /DreamAbode/public/adminProfile?section=add");
            exit();
        }
    }

    public function deleteProperty()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propertyId = $_POST['property_id'] ?? null;

            if (! $propertyId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            $result = $this->property->deleteProperty($propertyId);
            if ($result) {
                $_SESSION['msg'] = "Property deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete property.";
            }

            header("Location: /DreamAbode/public/adminProfile?section=add");
            exit();
        }
    }
}

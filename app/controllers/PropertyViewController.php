<?php
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../models/agentModel.php';
require_once __DIR__ . '/../models/contactAgentModel.php';
require_once __DIR__ . '/../../config/database.php';

class PropertyViewController
{
    private $conn;
    private $property;
    private $contact;
    private $agent;

    public function __construct()
    {
        $database       = new Database();
        $this->conn     = $database->connection();
        $this->contact  = new ContactAgent($this->conn);
        $this->property = new Property($this->conn);
        $this->agent    = new Agent($this->conn);
    }

    public function index()
    {
        require_once '../app/views/pages/propertyView.php';
    }

    public function viewProperty()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId     = $_SESSION['user_id'] ?? null;
            $propertyId = $_POST['property_id'] ?? null;

            if (! $propertyId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $this->property->propertyId = $propertyId;
            $viewProperty               = $this->property->getPropertyDetails();
            $imageBlobs                 = $this->property->getAllPropertyImages();

            if (! $viewProperty) {
                $_SESSION['error'] = "Property not found.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $encodedImages = [];
            foreach ($imageBlobs as $blob) {
                $encodedImages[] = base64_encode($blob);
            }

            $agentId = $viewProperty['AgentID'] ?? null;
            if ($agentId) {
                $agent = $this->agent->getUserProfile($agentId);
            }

            $_SESSION['viewProperty'] = array_merge($viewProperty, [
                'ImageData' => $encodedImages,
            ]);
            $_SESSION['agent'] = $agent;

            header("Location: /DreamAbode/public/propertyView");
            exit();
        } else {
            header("Location: /DreamAbode/public/home");
            exit();
        }
    }

    public function sendMessage()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId     = $_SESSION['user_id'] ?? null;
            $agentId    = $_POST['agent_id'] ?? null;
            $propertyId = $_POST['property_id'] ?? null;
            $name       = trim($_POST['name'] ?? '');
            $mobile     = trim($_POST['mobile'] ?? '');
            $email      = trim($_POST['email'] ?? '');
            $message    = trim($_POST['message'] ?? '');
            $type       = $_POST['contact_type'] ?? '';

            if (! $userId) {
                $_SESSION['error'] = "You have to login first.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            if (! $propertyId || ! $agentId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/propertyView");
                exit();
            }

            if ($type === 'call') {
                if (empty($name) || empty($mobile)) {
                    $_SESSION['error'] = "Name and contact number are required for a call.";
                    header("Location: /DreamAbode/public/propertyView");
                    exit();
                }
            } elseif ($type === 'email') {
                if (empty($name) || empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = "Valid name and email are required for email contact.";
                    header("Location: /DreamAbode/public/propertyView");
                    exit();
                }
            }

            $this->contact->propertyId  = $propertyId;
            $this->contact->memberId    = $userId;
            $this->contact->agentId     = $agentId;
            $this->contact->name        = $name;
            $this->contact->email       = $email;
            $this->contact->mobile      = $mobile;
            $this->contact->message     = $message;
            $this->contact->contactType = $type;

            if ($this->contact->saveMessage()) {
                $_SESSION['msg'] = "Message sent successfully.";
            } else {
                $_SESSION['error'] = "Failed to send message.";
            }

            header("Location: /DreamAbode/public/propertyView");
            exit();
        } else {
            header("Location: /DreamAbode/public/home");
            exit();
        }
    }

}

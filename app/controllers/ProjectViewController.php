<?php
require_once __DIR__ . '/../models/projectModel.php';
require_once __DIR__ . '/../models/agentModel.php';
require_once __DIR__ . '/../models/contactAgentModel.php';
require_once __DIR__ . '/../../config/database.php';

class ProjectViewController
{
    private $conn;
    private $project;
    private $contact;
    private $agent;

    public function __construct()
    {
        $database      = new Database();
        $this->conn    = $database->connection();
        $this->contact = new ContactAgent($this->conn);
        $this->project = new Project($this->conn);
        $this->agent   = new Agent($this->conn);
    }

    public function index()
    {
        require_once '../app/views/pages/projectView.php';
    }

    public function viewProject()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId    = $_SESSION['user_id'] ?? null;
            $projectId = $_POST['project_id'] ?? null;

            if (! $projectId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $this->project->projectId = $projectId;
            $viewProject              = $this->project->getprojectDetails();
            $imageBlobs               = $this->project->getAllprojectImages();

            if (! $viewProject) {
                $_SESSION['error'] = "Project not found.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $encodedImages = [];
            foreach ($imageBlobs as $blob) {
                $encodedImages[] = base64_encode($blob);
            }

            $agentId = $viewProject['AgentID'] ?? null;
            if ($agentId) {
                $agent = $this->agent->getUserProfile($agentId);
            }

            $_SESSION['viewProject'] = array_merge($viewProject, [
                'ImageData' => $encodedImages,
            ]);
            $_SESSION['agent'] = $agent;

            header("Location: /DreamAbode/public/projectView");
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
            $userId    = $_SESSION['user_id'] ?? null;
            $agentId   = $_POST['agent_id'] ?? null;
            $projectId = $_POST['project_id'] ?? null;
            $name      = trim($_POST['name'] ?? '');
            $mobile    = trim($_POST['mobile'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $message   = trim($_POST['message'] ?? '');
            $type      = $_POST['contact_type'] ?? '';

            if (! $userId) {
                $_SESSION['error'] = "You have to login first.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            if (! $projectId || ! $agentId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/projectView");
                exit();
            }

            if ($type === 'call') {
                if (empty($name) || empty($mobile)) {
                    $_SESSION['error'] = "Name and contact number are required for a call.";
                    header("Location: /DreamAbode/public/projectView");
                    exit();
                }
            } elseif ($type === 'email') {
                if (empty($name) || empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = "Valid name and email are required for email contact.";
                    header("Location: /DreamAbode/public/projectView");
                    exit();
                }
            }

            $this->contact->viewId      = $projectId;
            $this->contact->memberId    = $userId;
            $this->contact->agentId     = $agentId;
            $this->contact->name        = $name;
            $this->contact->email       = $email;
            $this->contact->mobile      = $mobile;
            $this->contact->message     = $message;
            $this->contact->contactType = $type;

            if ($this->contact->saveProjectMessage()) {
                $_SESSION['msg'] = "Message sent successfully.";
            } else {
                $_SESSION['error'] = "Failed to send message.";
            }

            header("Location: /DreamAbode/public/projectView");
            exit();
        } else {
            header("Location: /DreamAbode/public/home");
            exit();
        }
    }

}

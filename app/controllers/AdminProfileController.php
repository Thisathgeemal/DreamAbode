<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/AgentModel.php';
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../models/projectModel.php';
require_once __DIR__ . '/../../config/database.php';

class AdminProfileController
{
    private $conn;
    private $admin;
    private $property;
    private $agent;
    private $project;

    public function __construct()
    {
        $database       = new Database();
        $this->conn     = $database->connection();
        $this->admin    = new Admin($this->conn);
        $this->property = new Property($this->conn);
        $this->agent    = new Agent($this->conn);
        $this->member   = new Member($this->conn);
        $this->project  = new Project($this->conn);
    }

    public function index()
    {
        $this->checkLogin();

        $userId   = $_SESSION['user_id'];
        $userData = $this->admin->getUserProfile($userId);

        $pendingProperties  = $this->property->getAllPropertyRequest();
        $acceptedProperties = $this->property->getAcceptedProperties();
        $rejectedProperties = $this->property->getRejectedProperties();

        $pendingProjects  = $this->project->getAllProjectRequests();
        $acceptedProjects = $this->project->getAcceptedProjects();
        $rejectedProjects = $this->project->getRejectedProjects();

        $viewAgents  = $this->agent->getAllAgents();
        $viewMembers = $this->member->getAllMembers();
        $viewAdmins  = $this->admin->getAllAdmins();

        $adminCount  = $this->admin->adminCount('Admin');
        $agentCount  = $this->agent->agentCount();
        $memberCount = $this->member->memberCount();

        $pendingPropertyCount = $this->property->propertyCountByStatus('Pending');
        $pendingProjectCount  = $this->project->projectCountByStatus('Pending');
        $acceptPropertyCount  = $this->property->propertyCountByStatus('Accept');
        $acceptProjectCount   = $this->project->projectCountByStatus('Accept');
        $acceptAdCount        = $acceptPropertyCount + $acceptProjectCount;

        require_once '../app/views/dashboard/adminProfile.php';
    }

    public function checkLogin()
    {
        session_start();
        if (! isset($_SESSION['user_id']) || ! isset($_SESSION['user_role'])) {
            header("Location: /DreamAbode/public/login");
            exit();
        }

        if ($_SESSION['user_role'] !== 'admin') {
            header("Location: /DreamAbode/public/unauthorized");
            exit();
        }
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

    public function deleteAdmin()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ! empty($_POST['admin_ids'])) {
            $deleted = 0;
            foreach ($_POST['admin_ids'] as $userId) {
                if ($this->admin->removeAdminById($userId)) {
                    $deleted++;
                }
            }

            if ($deleted > 0) {
                $_SESSION['msg'] = "$deleted admin(s) deleted successfully!";
            } else {
                $_SESSION['msg'] = "No admins were deleted.";
            }
        } else {
            $_SESSION['msg'] = "No admins selected for deletion.";
        }

        header("Location: /DreamAbode/public/adminProfile?section=admin");
        exit();
    }

    public function createAdmin()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $mobile   = trim($_POST['mobile']);
            $password = trim($_POST['password']);
            $dob      = trim($_POST['dob']);
            $gender   = trim($_POST['gender']);

            $this->admin->username = $username;
            $this->admin->password = $password;
            $this->admin->email    = $email;
            $this->admin->mobile   = $mobile;
            $this->admin->dob      = $dob;
            $this->admin->gender   = $gender;

            // Basic validations
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg'] = "Invalid email format!";
            } elseif (! preg_match('/^[0-9]{10}$/', $mobile)) {
                $_SESSION['msg'] = "Invalid mobile number!";
            } else {

                if ($this->admin->isUsernameExists() && $this->admin->isEmailExists()) {
                    $_SESSION['msg'] = "Username and email already exist!";
                } elseif ($this->admin->isUsernameExists()) {
                    $_SESSION['msg'] = "Username already exists!";
                } elseif ($this->admin->isEmailExists()) {
                    $_SESSION['msg'] = "Email already exists!";
                } else {
                    if ($this->admin->addadmin()) {
                        $_SESSION['msg'] = "Admin created successfully!";
                    } else {
                        $_SESSION['error'] = "Failed to register admin. Please try again.";
                    }
                    header("Location: /DreamAbode/public/adminProfile?section=admin");
                    exit();
                }
            }

            header("Location: /DreamAbode/public/adminProfile?section=admin");
            exit();
        } else {
            header("Location: /DreamAbode/public/login");
            exit();
        }
    }

    public function handleProjectRequest()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId    = $_SESSION['user_id'] ?? null;
            $projectId = $_POST['project_id'] ?? null;
            $action    = $_POST['action'] ?? null;

            if (! $userId || ! $projectId || ! $action) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            if ($action === 'Accept') {
                $result = $this->project->assignAgentAndAccept($projectId, $userId);
                if ($result) {
                    $_SESSION['msg'] = "Project request accepted and agent assigned successfully.";
                } else {
                    $_SESSION['error'] = "Failed to accept project request.";
                }

            } elseif ($action === 'Reject') {
                $result = $this->project->rejectProjectRequest($projectId, $userId);
                if ($result) {
                    $_SESSION['msg'] = "Project request rejected successfully.";
                } else {
                    $_SESSION['error'] = "Failed to reject project request.";
                }

            } else {
                $_SESSION['error'] = "Invalid action.";
            }

            header("Location: /DreamAbode/public/adminProfile?section=projects");
            exit();
        }
    }

    public function deleteProject()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'] ?? null;

            if (! $projectId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            $result = $this->project->deleteProject($projectId);
            if ($result) {
                $_SESSION['msg'] = "Project deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete project.";
            }

            header("Location: /DreamAbode/public/adminProfile?section=projects");
            exit();
        }
    }

}

<?php
require_once __DIR__ . '/../models/ProjectModel.php';
require_once __DIR__ . '/../../config/database.php';

class PostProjectController
{
    private $conn;
    private $project;

    public function __construct()
    {
        $database      = new Database();
        $this->conn    = $database->connection();
        $this->project = new Project($this->conn);
    }

    public function index()
    {
        require_once '../app/views/pages/postProject.php';
    }

    public function addProject()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? null;
            if (! $userId) {
                $_SESSION['error'] = "You must be logged in to post an ad.";
                header("Location: /DreamAbode/public/login");
                exit();
            }

            // Check image upload count limit (max 6)
            if (isset($_FILES['images']['tmp_name']) && count($_FILES['images']['tmp_name']) > 6) {
                $_SESSION['error'] = "You can upload up to 6 images only.";
                header("Location: /DreamAbode/public/postProject");
                exit();
            }

            // Assign and sanitize form values
            $this->project->projectName    = trim($_POST['projectName']);
            $this->project->location       = trim($_POST['location']);
            $this->project->price          = (float) trim($_POST['price']);
            $this->project->completionDate = trim($_POST['completionDate']);
            $this->project->totalUnits     = (int) trim($_POST['totalUnits']);
            $this->project->measurement    = (int) trim($_POST['measurement']);
            $this->project->memberId       = $userId;

            // Create project entry
            if ($this->project->createProject()) {
                $projectId = $this->project->getLastInsertedID();

                // Save images as binary data
                if (! empty($_FILES['images']['tmp_name'][0])) {
                    foreach ($_FILES['images']['tmp_name'] as $tmpName) {
                        $imageData = file_get_contents($tmpName);
                        $this->project->insertProjectImages($projectId, $imageData);
                    }
                }

                $_SESSION['msg'] = "Project added successfully!";
                header("Location: /DreamAbode/public/memberProfile?section=manage_project");
                exit();
            } else {
                $_SESSION['error'] = "Failed to add project.";
                header("Location: /DreamAbode/public/postProject");
                exit();
            }
        } else {
            header("Location: /DreamAbode/public/postProject");
            exit();
        }
    }

}

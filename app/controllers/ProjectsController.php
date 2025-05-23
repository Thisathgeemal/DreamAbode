<?php
require_once __DIR__ . '/../models/projectModel.php';
require_once __DIR__ . '/../../config/database.php';

class ProjectsController
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
        $projects = $this->project->getAcceptedProjects();
        require_once '../app/views/pages/projects.php';
    }
}

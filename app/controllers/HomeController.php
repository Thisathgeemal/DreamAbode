<?php
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class HomeController
{
    private $conn;
    private $property;

    public function __construct()
    {
        $database       = new Database();
        $this->conn     = $database->connection();
        $this->property = new Property($this->conn);
    }

    public function index()
    {
        $randomProperties = $this->property->getRandomAcceptedProperties();
        require_once '../app/views/pages/home.php';
    }
}

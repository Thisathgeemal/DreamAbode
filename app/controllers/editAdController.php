<?php
require_once __DIR__ . '/../models/PropertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class EditAdController
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
        require_once '../app/views/pages/editAd.php';

    }

}

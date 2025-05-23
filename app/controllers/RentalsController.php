<?php
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class RentalsController
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
        $randomProperties = $this->property->getRandomPropertyByPostType('Rental');
        require_once '../app/views/pages/rentals.php';
    }
}

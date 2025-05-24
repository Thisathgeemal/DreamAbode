<?php
require_once __DIR__ . '/../models/reviewModel.php';
require_once __DIR__ . '/../../config/database.php';

class AboutController
{
    private $conn;
    private $review;

    public function __construct()
    {
        $database     = new Database();
        $this->conn   = $database->connection();
        $this->review = new Review($this->conn);
    }

    public function index()
    {
        $randomReviews = $this->review->getRandomReviewData(3);
        require_once '../app/views/pages/about.php';
    }
}

<?php
require_once __DIR__ . '/../models/reviewModel.php';
require_once __DIR__ . '/../../config/database.php';

class ReviewController
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
        require_once '../app/views/pages/review.php';
    }

    public function addReview()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reviewText = isset($_POST['message']) ? trim($_POST['message']) : '';
            $rating     = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
            $user_id    = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            if (empty($user_id)) {
                $_SESSION['error'] = "Login first to ad a review.";
                header("Location: /DreamAbode/public/review");
                exit();
            }

            $this->review->memberId = $user_id;

            if (! empty($reviewText) && $rating > 0 && $rating <= 5) {
                $this->review->description = $reviewText;
                $this->review->rating      = $rating;

                if ($this->review->addReview()) {
                    $_SESSION['msg'] = "Review Added successfully.";
                    header("Location: /DreamAbode/public/about");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add review.";
                    header("Location: /DreamAbode/public/review");
                    exit();
                }

            } else {
                $_SESSION['error'] = "Invalid input or missing data.";
                header("Location: /DreamAbode/public/review");
                exit();
            }

        } else {
            header("Location: /DreamAbode/public/about");
            exit();
        }
    }

}

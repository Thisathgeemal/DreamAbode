<?php
class Review
{
    private $table = "review";

    public $reviewId;
    public $rating;
    public $description;
    public $date;
    public $memberId;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addReview()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (Rating, Description, Date, MemberID)
                      VALUES (:rating, :description, NOW(), :memberId)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':rating', $this->rating);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':memberId', $this->memberId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("DB Error: " . $e->getMessage());
            return false;
        }
    }

    public function getRandomReviewData($limit)
    {
        $query = "SELECT r.*, m.Username, m.Image
                  FROM " . $this->table . " r
                  INNER JOIN member m ON r.MemberID = m.ID
                  ORDER BY RAND()
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

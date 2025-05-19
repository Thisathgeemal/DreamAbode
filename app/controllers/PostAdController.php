<?php
require_once __DIR__ . '/../models/PropertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class PostAdController
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
        require_once '../app/views/pages/postAd.php';
    }

    public function addProperty()
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
                header("Location: /DreamAbode/public/postAd");
                exit();
            }

            $this->property->propertyName = trim($_POST['propertyName']);
            $this->property->location     = trim($_POST['location']);
            $this->property->measurement  = trim($_POST['measurement']);
            $this->property->price        = trim($_POST['price']);
            $this->property->propertyType = trim($_POST['propertyType']);
            $this->property->postType     = trim($_POST['postType']);
            $this->property->bedrooms     = trim($_POST['bedroomCount']);
            $this->property->bathrooms    = trim($_POST['bathroomCount']);
            $this->property->floors       = trim($_POST['floorCount']);
            $this->property->perches      = trim($_POST['perches']);
            $this->property->memberId     = $userId;

            // Create property entry
            if ($this->property->createProperty()) {
                $propertyId = $this->property->getLastInsertedID();

                // Save images as binary data
                if (! empty($_FILES['images']['tmp_name'][0])) {
                    foreach ($_FILES['images']['tmp_name'] as $tmpName) {
                        $imageData = file_get_contents($tmpName);
                        $this->property->insertPropertyImages($propertyId, $imageData);
                    }
                }

                $_SESSION['msg'] = "Property added successfully!";
                header("Location: /DreamAbode/public/memberProfile?section=manage_ad");
                exit();
            } else {
                $_SESSION['error'] = "Failed to add property.";
                header("Location: /DreamAbode/public/postAd");
                exit();
            }
        } else {
            header("Location: /DreamAbode/public/postAd");
            exit();
        }
    }

}

<?php
require_once __DIR__ . '/../models/propertyModel.php';
require_once __DIR__ . '/../../config/database.php';

class PropertyViewController
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
        require_once '../app/views/pages/propertyView.php';
    }

    public function viewProperty()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId     = $_SESSION['user_id'] ?? null;
            $propertyId = $_POST['property_id'] ?? null;

            if (! $propertyId) {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $this->property->propertyId = $propertyId;
            $viewProperty               = $this->property->getPropertyDetails();
            $imageBlobs                 = $this->property->getAllPropertyImages();

            $encodedImages = [];
            foreach ($imageBlobs as $blob) {
                $encodedImages[] = base64_encode($blob);
            }

            if (! $viewProperty) {
                $_SESSION['error'] = "Property not found.";
                header("Location: /DreamAbode/public/home");
                exit();
            }

            $_SESSION['viewProperty'] = array_merge($viewProperty, [
                'ImageData' => $encodedImages,
            ]);

            header("Location: /DreamAbode/public/propertyView");
            exit();
        } else {

            header("Location: /DreamAbode/public/home");
            exit();
        }
    }

}

<?php
class Property
{
    private $table = "propertyAd";

    public $propertyId;
    public $propertyName;
    public $propertyType;
    public $location;
    public $perches;
    public $price;
    public $postType;
    public $status;
    public $isPromoted;
    public $images;
    public $memberId;
    public $agentId;
    public $adminId;
    public $bedrooms;
    public $bathrooms;
    public $floors;
    public $measurement;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createProperty()
    {
        $query = "INSERT INTO " . $this->table . " (PropertyName, PropertyType, Location, Measurement, Price, PostType, Bedrooms, Bathrooms, Floors, Perches, MemberId) VALUES (:propertyName, :propertyType, :location, :measurement, :price, :postType, :bedrooms, :bathrooms, :floors, :perches, :memberId)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':propertyName', $this->propertyName);
        $stmt->bindParam(':propertyType', $this->propertyType);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':measurement', $this->measurement);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':postType', $this->postType);
        $stmt->bindParam(':bedrooms', $this->bedrooms);
        $stmt->bindParam(':bathrooms', $this->bathrooms);
        $stmt->bindParam(':floors', $this->floors);
        $stmt->bindParam(':perches', $this->perches);
        $stmt->bindParam(':memberId', $this->memberId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLastInsertedID()
    {
        return $this->conn->lastInsertId();
    }

    public function insertPropertyImages($propertyId, $imageData)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO PropertyImages (PropertyId, ImageData, UploadedAt) VALUES (?, ?, NOW())");
            $stmt->bindParam(1, $propertyId);
            $stmt->bindParam(2, $imageData, PDO::PARAM_LOB);
            return $stmt->execute();
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                die("Image is too large. Please upload a smaller image (e.g., under 1MB).");
            } else {
                die("Database error: " . $e->getMessage());
            }
        }
    }

}

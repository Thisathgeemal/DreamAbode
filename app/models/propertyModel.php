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

    public function getAllPropertyRequest()
    {
        try {
            $query = "SELECT
                    p.*,
                    (SELECT ImageData
                     FROM PropertyImages
                     WHERE PropertyId = p.PropertyId
                     ORDER BY UploadedAt ASC
                     LIMIT 1) AS ImageData
                  FROM " . $this->table . " p
                  WHERE p.Status = 'pending'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Failed to fetch properties: " . $e->getMessage());
        }
    }

    public function getPropertiesByUserId($userId)
    {
        $query = "SELECT
                    p.*,
                    (SELECT ImageData
                     FROM PropertyImages
                     WHERE PropertyId = p.PropertyId
                     ORDER BY UploadedAt ASC
                     LIMIT 1) AS ImageData
                  FROM {$this->table} p
                  WHERE p.MemberID = :userId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function grtAllProperties()
    {
        $query = "SELECT p.*, a.Username as AgentName
                  FROM propertyAd p
                  LEFT JOIN agent a ON p.AgentID = a.ID
                  ORDER BY P.CreatedAt DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($propertyId, $status, $adminId)
    {
        if ($status === 'Accept') {
            $agent   = $this->assignAgent();
            $agentId = $agent ? $agent['ID'] : null;

            $query = "UPDATE propertyAd SET Status = :status, AgentID = :agentId, AdminID = :adminId WHERE PropertyID = :propertyId";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute([
                ':status'     => $status,
                ':agentId'    => $agentId,
                ':adminId'    => $adminId,
                ':propertyId' => $propertyId,
            ]);
            return ['agentName' => $agent ? $agent['Username'] : null];
        } else {
            $query = "UPDATE propertyAd SET Status = :status, AgentID = NULL, AdminID = :adminId WHERE PropertyID = :propertyId";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute([
                ':status'     => $status,
                ':adminId'    => $adminId,
                ':propertyId' => $propertyId,
            ]);
            return ['agentName' => null];
        }
    }

    public function assignAgent()
    {
        $query = "SELECT a.ID, a.Username, COUNT(P.PropertyID) AS assignedCount
                  FROM agent a
                  LEFT JOIN propertyAd p ON a.ID = p.AgentID AND p.Status = 'Accept'
                  GROUP BY a.ID
                  ORDER BY assignedCount ASC
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

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
            $query = "INSERT INTO PropertyImages (PropertyId, ImageData, UploadedAt) VALUES (?, ?, NOW())";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(1, $propertyId);
            $stmt->bindParam(2, $imageData, PDO::PARAM_LOB);
            return $stmt->execute();

        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                die("Image is too large. Please upload a smaller image (e.g., under 64MB).");
            } else {
                die("Database error: " . $e->getMessage());
            }
        }
    }

    //get pending request
    public function getAllPropertyRequest()
    {
        try {
            $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'pending'";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Failed to fetch properties: " . $e->getMessage());
        }
    }

    // get relevant member pending properties
    public function getPendingPropertiesByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Pending'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get relevant member accept
    public function getAcceptedPropertiesByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Accept'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get relevant member rejected properties
    public function getRejectedPropertiesByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Reject'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get agent id for assignment
    public function getNextAgentId()
    {
        $query = "SELECT agent.ID FROM agent LEFT JOIN propertyAd ON agent.ID = propertyAd.AgentID AND propertyAd.Status = 'Accept' GROUP BY agent.ID ORDER BY COUNT(propertyAd.PropertyID) ASC LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agent) {
            return $agent['ID'];
        }
        return null;
    }

    // assign agent and update property status
    public function assignAgentAndAccept($propertyId, $userId)
    {
        $agentId = $this->getNextAgentId();
        if ($agentId) {
            $query = "UPDATE propertyAd SET Status = 'Accept', AgentID = :agentId, AdminID = :adminId WHERE PropertyID = :propertyId";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute([
                ':agentId'    => $agentId,
                ':adminId'    => $userId,
                ':propertyId' => $propertyId,
            ]);
            return true;
        }
        return false;
    }

    // reject property request
    public function rejectPropertyRequest($propertyId, $userId)
    {
        $query = "UPDATE " . $this->table . " SET Status = 'Reject', AdminID = :adminId WHERE PropertyID = :propertyId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':adminId', $userId);
        $stmt->bindParam(':propertyId', $propertyId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete property
    public function deleteProperty($propertyId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE PropertyID = :propertyId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':propertyId', $propertyId);
        return $stmt->execute();
    }

    // get accept properties
    public function getAcceptedProperties()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'Accept'";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get rejected properties
    public function getRejectedProperties()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'Reject'";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get property details by ID
    public function getPropertyDetails()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.PropertyId = :propertyId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':propertyId', $this->propertyId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update property details
    public function updatePropertyDetails()
    {
        $query = "UPDATE " . $this->table . " SET PropertyName = :propertyName, PropertyType = :propertyType, Location = :location, Measurement = :measurement, Price = :price, PostType = :postType, Bedrooms = :bedrooms, Bathrooms = :bathrooms, Floors = :floors, Perches = :perches WHERE PropertyID = :propertyId";
        $stmt  = $this->conn->prepare($query);

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
        $stmt->bindParam(':propertyId', $this->propertyId);

        $executed = $stmt->execute();
        return $executed;

    }

    public function getRandomAcceptedProperties($limit = 3)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE PropertyId = p.PropertyId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'Accept' ORDER BY RAND() LIMIT :limit";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

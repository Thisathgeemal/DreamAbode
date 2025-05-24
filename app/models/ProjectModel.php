<?php
class Project
{
    private $table = "projectAd";

    public $projectId;
    public $projectName;
    public $propertyType;
    public $location;
    public $totalUnits;
    public $completionDate;
    public $measurement;
    public $price;
    public $status;
    public $isPromoted;
    public $images;
    public $memberId;
    public $agentId;
    public $adminId;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createProject()
    {
        $query = "INSERT INTO " . $this->table . " (ProjectName, Location, TotalUnits, CompletionDate, Measurement, Price, MemberId) 
                  VALUES (:projectName, :location, :totalUnits, :completionDate, :measurement, :price, :memberId)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':projectName', $this->projectName);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':totalUnits', $this->totalUnits);
        $stmt->bindParam(':completionDate', $this->completionDate);
        $stmt->bindParam(':measurement', $this->measurement);
        $stmt->bindParam(':price', $this->price);
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

    public function insertProjectImages($projectId, $imageData)
    {
        try {
            $query = "INSERT INTO ProjectImages (ProjectID, ImageData, UploadedAt) VALUES (?, ?, NOW())";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(1, $projectId);
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

    // get pending project request
    public function getAllProjectRequests()
    {
        try {
            $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'pending'";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Failed to fetch projects: " . $e->getMessage());
        }
    }

    // get pending projects by user
    public function getPendingProjectsByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Pending'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get accepted projects by user
    public function getAcceptedProjectsByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData 
                  FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Accept'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get rejected projects by user
    public function getRejectedProjectsByUserId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM {$this->table} p WHERE p.MemberID = :userId AND p.Status = 'Reject'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get agent id for assignment
    public function getNextAgentId()
    {
        $query = "SELECT agent.ID FROM agent LEFT JOIN projectAd ON agent.ID = projectAd.AgentID AND projectAd.Status = 'Accept' GROUP BY agent.ID ORDER BY COUNT(projectAd.ProjectID) ASC LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agent) {
            return $agent['ID'];
        }
        return null;
    }

    // assign agent and update project status
    public function assignAgentAndAccept($projectId, $userId)
    {
        $agentId = $this->getNextAgentId();
        if ($agentId) {
            $query = "UPDATE projectAd SET Status = 'Accept', AgentID = :agentId, AdminID = :adminId WHERE ProjectID = :projectId";
            $stmt  = $this->conn->prepare($query);
            $stmt->execute([
                ':agentId'   => $agentId,
                ':adminId'   => $userId,
                ':projectId' => $projectId,
            ]);
            return true;
        }
        return false;
    }

    // reject project request
    public function rejectProjectRequest($projectId, $adminId)
    {
        $query = "UPDATE " . $this->table . " SET Status = 'Reject', AdminID = :adminId WHERE ProjectID = :projectId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':adminId', $adminId);
        $stmt->bindParam(':projectId', $projectId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete project
    public function deleteProject($projectId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE ProjectID = :projectId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        return $stmt->execute();
    }

    // get all accepted projects
    public function getAcceptedProjects()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'Accept'";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get all rejected projects
    public function getRejectedProjects()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.Status = 'Reject'";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get details of a specific project by id
    public function getProjectDetails()
    {
        $query = "SELECT p.*, (SELECT ImageData FROM PropertyImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.ProjectId = :projectId";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $this->projectId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get all images for a project
    public function getAllProjectImages()
    {
        $query = "SELECT ImageData FROM ProjectImages WHERE ProjectId = :projectId ORDER BY UploadedAt ASC";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $this->projectId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // update project details
    public function updateProjectDetails()
    {
        $query = "UPDATE " . $this->table . " SET ProjectName = :projectName, Location = :location, TotalUnits = :totalUnits, 
                  CompletionDate = :completionDate, Measurement = :measurement, Price = :price WHERE ProjectID = :projectId";
        $stmt  = $this->conn->prepare($query);

        $stmt->bindParam(':projectName', $this->projectName);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':totalUnits', $this->totalUnits);
        $stmt->bindParam(':completionDate', $this->completionDate);
        $stmt->bindParam(':measurement', $this->measurement);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':projectId', $this->projectId);

        $executed = $stmt->execute();
        return $executed;
    }

    // get project count
    public function projectCountByStatus($status)
    {
        try {
            $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE Status = :status";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();

            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    //get projects assign to agents
    public function getProjectsByAgentId($userId)
    {
        $query = "SELECT p.*, (SELECT ImageData FROM ProjectImages WHERE ProjectId = p.ProjectId ORDER BY UploadedAt ASC LIMIT 1) AS ImageData FROM " . $this->table . " p WHERE p.AgentID = :userId AND p.Status = 'Accept'";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get agents assign project count
    public function assignedProjectCount($userId)
    {
        try {
            $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE AgentID = :userId AND Status = 'Accept'";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetchColumn();

        } catch (PDOException $e) {
            return 0;
        }
    }

    // get project request count based on userId and status
    public function getProjectCountByIdAndStatus($userId, $status)
    {
        try {
            $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE MemberID = :userId AND Status = :status";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            $stmt->execute();
            return (int) $stmt->fetchColumn();

        } catch (PDOException $e) {
            return 0;
        }
    }

}

<?php
class ContactAgent
{
    private $table = "contactAgent";

    public $messageId;
    public $name;
    public $email;
    public $mobile;
    public $message;
    public $viewId;
    public $memberId;
    public $agentId;
    public $contactType;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function savePropertyMessage()
    {
        $query = "INSERT INTO contactAgent (Name, Email, MobileNumber, Message, ViewID, MemberID, AgentID, ContactType, sent_at) VALUES (:name, :email, :mobile, :message, :viewID, :memberID, :agentID, :contactType, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':viewID', $this->viewId);
        $stmt->bindParam(':memberID', $this->memberId);
        $stmt->bindParam(':agentID', $this->agentId);
        $stmt->bindParam(':contactType', $this->contactType);

        if ($stmt->execute()) {
            $this->messageId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function saveProjectMessage()
    {
        $query = "INSERT INTO contactAgent (Name, Email, MobileNumber, Message, ViewID, MemberID, AgentID, ContactType, sent_at) VALUES (:name, :email, :mobile, :message, :viewID, :memberID, :agentID, :contactType, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':viewID', $this->viewId);
        $stmt->bindParam(':memberID', $this->memberId);
        $stmt->bindParam(':agentID', $this->agentId);
        $stmt->bindParam(':contactType', $this->contactType);

        if ($stmt->execute()) {
            $this->messageId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function getMessage($userId, $contactType)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE AgentID = :userId AND ContactType = :contactType ORDER BY sent_at ASC";
        $stmt  = $this->conn->prepare($query);

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':contactType', $contactType, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function receivedMessageCount($userId, $contactType)
    {
        try {
            $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE AgentID = :userId AND ContactType = :contactType";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':contactType', $contactType, PDO::PARAM_STR);

            $stmt->execute();
            return (int) $stmt->fetchColumn();

        } catch (PDOException $e) {
            return 0;
        }
    }

}

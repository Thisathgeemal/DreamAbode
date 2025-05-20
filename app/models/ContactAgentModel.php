<?php
class ContactAgent
{
    private $table = "contactAgent";

    public $messageId;
    public $name;
    public $email;
    public $mobile;
    public $message;
    public $propertyId;
    public $memberId;
    public $agentId;
    public $contactType;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function saveMessage()
    {
        $query = "INSERT INTO contactAgent (Name, Email, MobileNumber, Message, PropertyID, MemberID, AgentID, ContactType, sent_at) VALUES (:name, :email, :mobile, :message, :propertyID, :memberID, :agentID, :contactType, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':propertyID', $this->propertyId);
        $stmt->bindParam(':memberID', $this->memberId);
        $stmt->bindParam(':agentID', $this->agentId);
        $stmt->bindParam(':contactType', $this->contactType);

        if ($stmt->execute()) {
            $this->messageId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

}

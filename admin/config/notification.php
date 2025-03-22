<?php
require_once 'db.php';

class Notification {
    private $conn;
    private $table_name = "notifications";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertNotification($user, $email, $message) {
        $query = "INSERT INTO " . $this->table_name . " (user, email, message) VALUES (:user, :email, :message)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":message", $message);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>

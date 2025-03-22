<?php
require_once 'db.php';

class SocialMedia {
    private $conn;

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    // Fetch all records
    public function getAllSocialMedia() {
        $query = "SELECT * FROM social_media ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert a new record
    public function insertSocialMedia($facebook, $youtube, $twitter, $telegram, $another_url) {
        $query = "INSERT INTO social_media (facebook, youtube, twitter, telegram, another_url) 
                  VALUES (:facebook, :youtube, :twitter, :telegram, :another_url)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':facebook', $facebook);
        $stmt->bindParam(':youtube', $youtube);
        $stmt->bindParam(':twitter', $twitter);
        $stmt->bindParam(':telegram', $telegram);
        $stmt->bindParam(':another_url', $another_url);

        return $stmt->execute();
    }

    // Update an existing record
    public function updateSocialMedia($id, $facebook, $youtube, $twitter, $telegram, $another_url) {
        $query = "UPDATE social_media SET facebook = :facebook, youtube = :youtube, twitter = :twitter, 
                  telegram = :telegram, another_url = :another_url WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':facebook', $facebook);
        $stmt->bindParam(':youtube', $youtube);
        $stmt->bindParam(':twitter', $twitter);
        $stmt->bindParam(':telegram', $telegram);
        $stmt->bindParam(':another_url', $another_url);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete a record
    public function deleteSocialMedia($id) {
        $query = "DELETE FROM social_media WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

// Handling the POST request for saving or deleting data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create an instance of the SocialMedia class
    $socialMedia = new SocialMedia();

    // Check if it's a save or delete request
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'save') {
            // Save or update data
            $id = $_POST['id'] ?? null;
            $facebook = $_POST['facebook'] ?? '';
            $youtube = $_POST['youtube'] ?? '';
            $twitter = $_POST['twitter'] ?? '';
            $telegram = $_POST['telegram'] ?? '';
            $another_url = $_POST['another_url'] ?? null;

            if ($id) {
                // Update existing record
                $socialMedia->updateSocialMedia($id, $facebook, $youtube, $twitter, $telegram, $another_url);
            } else {
                // Insert new record
                $socialMedia->insertSocialMedia($facebook, $youtube, $twitter, $telegram, $another_url);
            }

            echo json_encode(['status' => 'success', 'message' => 'Data saved successfully!']);
        }

        if ($_POST['action'] == 'delete' && isset($_POST['id'])) {
            // Delete record
            $id = $_POST['id'];
            $socialMedia->deleteSocialMedia($id);
           
        }
    }
}
?>

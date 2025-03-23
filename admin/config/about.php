<?php
require_once 'db.php';

class About {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Insert data into the about_us table
    public function insertAboutData($section_title, $story_title, $story_content, $mission_title, $mission_content, $quote, $quote_author, $story_image, $mission_image, $team_title, $team_content, $team_image) {
        // Handle file uploads correctly
        $story_image_path = $this->uploadFile($story_image, 'story_images');
        $mission_image_path = $this->uploadFile($mission_image, 'mission_images');
        $team_image_path = $this->uploadFile($team_image, 'team_images');

        // Insert data into the database
        $sql = "INSERT INTO about_us (section_title, story_title, story_content, mission_title, mission_content, quote, quote_author, story_image, mission_image, team_title, team_content, team_image) 
                VALUES (:section_title, :story_title, :story_content, :mission_title, :mission_content, :quote, :quote_author, :story_image, :mission_image, :team_title, :team_content, :team_image)";
        $params = [
            'section_title' => $section_title,
            'story_title' => $story_title,
            'story_content' => $story_content,
            'mission_title' => $mission_title,
            'mission_content' => $mission_content,
            'quote' => $quote,
            'quote_author' => $quote_author,
            'story_image' => $story_image_path,
            'mission_image' => $mission_image_path,
            'team_title' => $team_title,
            'team_content' => $team_content,
            'team_image' => $team_image_path
        ];
        $this->runQuery($sql, $params);

        return $this->conn->lastInsertId();
    }

    // Fetch a single record based on ID
    public function getAboutData($id) {
        $sql = "SELECT * FROM about_us WHERE id = :id";
        $params = ['id' => $id];
        $stmt = $this->runQuery($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all records from the about_us table
    public function getAllAboutData() {
        $sql = "SELECT * FROM about_us";
        $stmt = $this->runQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an existing record
    public function updateAboutData($id, $section_title, $story_title, $story_content, $mission_title, $mission_content, $quote, $quote_author, $story_image, $mission_image, $team_title, $team_content, $team_image) {
        // Handle file uploads for updated images
        $story_image_path = $this->uploadFile($story_image, 'story_images');
        $mission_image_path = $this->uploadFile($mission_image, 'mission_images');
        $team_image_path = $this->uploadFile($team_image, 'team_images');

        // Update record in the database
        $sql = "UPDATE about_us SET section_title = :section_title, story_title = :story_title, story_content = :story_content, mission_title = :mission_title, mission_content = :mission_content, 
                quote = :quote, quote_author = :quote_author, story_image = :story_image, mission_image = :mission_image, team_title = :team_title, team_content = :team_content, team_image = :team_image
                WHERE id = :id";
        $params = [
            'id' => $id,
            'section_title' => $section_title,
            'story_title' => $story_title,
            'story_content' => $story_content,
            'mission_title' => $mission_title,
            'mission_content' => $mission_content,
            'quote' => $quote,
            'quote_author' => $quote_author,
            'story_image' => $story_image_path,
            'mission_image' => $mission_image_path,
            'team_title' => $team_title,
            'team_content' => $team_content,
            'team_image' => $team_image_path
        ];
        $this->runQuery($sql, $params);
    }

    // Delete a record by ID
    public function deleteAboutData($id) {
        $sql = "DELETE FROM about_us WHERE id = :id";
        $params = ['id' => $id];
        $this->runQuery($sql, $params);
    }

    // Helper function to run queries
    private function runQuery($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // Handle file upload (used for both inserting and updating)
    private function uploadFile($file, $folder) {
        $target_dir = "uploads/" . $folder . "/";
        
        // Ensure the folder exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        if (getimagesize($file["tmp_name"]) === false) {
            die("File is not an image.");
        }

        // Check file size (limit to 5MB)
        if ($file["size"] > 5000000) {
            die("Sorry, your file is too large.");
        }

        // Allow certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Try to upload file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file; // Return file path if upload is successful
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }
}
?>

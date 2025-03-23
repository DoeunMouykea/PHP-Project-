<?php 
require_once 'db.php';
class Article {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Insert article data into the database
    public function insertArticle($title, $content, $category, $image) {
        $imagePath = $this->uploadFile($image, 'article_images');

        $sql = "INSERT INTO articles (title, content, category, image) VALUES (:title, :content, :category, :image)";
        $params = [
            ':title' => $title,
            ':content' => $content,
            ':category' => $category,
            ':image' => $imagePath
        ];

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Fetch latest articles
    public function getArticles($limit = 3) {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Delete article by ID
    public function deleteArticle($id) {
        // SQL query to delete the article by ID
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Fetch article by ID
    public function getArticleById($id) {
        $query = "SELECT * FROM articles WHERE id = :id";
        $stmt = $this->conn->prepare($query); // Use $this->conn here
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update article
    public function updateArticle($id, $title, $content, $category, $image = null) {
        $query = "UPDATE articles SET title = :title, content = :content, category = :category, image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query); // Use $this->conn here

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // Upload image
    private function uploadFile($file, $folder) {
        // Define the target directory for the images
        $target_dir = "uploads/" . $folder . "/";

        // Check if the target directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        // Define the target file path
        $target_file = $target_dir . uniqid() . "-" . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        if (getimagesize($file["tmp_name"]) === false) {
            die("File is not an image.");
        }

        // Check file size (limit to 5MB)
        if ($file["size"] > 5000000) {
            die("File is too large.");
        }

        // Allow certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            die("Only JPG, JPEG, PNG & GIF allowed.");
        }

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file; // Return the file path if the upload is successful
        } else {
            die("Error uploading file: " . $file["error"]);
        }
    }
}
?>
<?php
 require_once 'db.php';
 
class Slide {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Insert slide with image upload
 
    public function insertSlide($title, $description, $link, $image, $order_number) {
        $targetDir = "images/";  // The folder where images will be saved
        $imageFileName = basename($image["name"]);  // Get the image file name
        $targetFile = $targetDir . $imageFileName;  // Full path to save the image

        // Try to move the uploaded image to the 'images/' directory
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $imagePath = $targetDir . $imageFileName;  // Path to store in the DB

            // Prepare SQL query to insert the slide into the database
            $sql = "INSERT INTO slides (title, description, link, image, order_number) 
                    VALUES (:title, :description, :link, :image, :order_number)";
            $stmt = $this->conn->prepare($sql);
            
            // Execute the statement with the slide data
            $stmt->execute([
                ":title" => $title,
                ":description" => $description,
                ":link" => $link,
                ":image" => $imageFileName,  // Store only the filename (relative path)
                ":order_number" => $order_number
            ]);

            return ["success" => true];  // Success response
        } else {
            return ["success" => false, "error" => "Image upload failed."];  // Failure response
        }
    }

    
    // Delete slide
    public function deleteSlide($id) {
        // Fetch the slide information without deleting the image
        $sql = "SELECT image FROM slides WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($slide) {
            // Delete the slide from the database
            $sql = "DELETE FROM slides WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([":id" => $id]);
    
            return ["success" => true];
        } else {
            return ["success" => false, "error" => "Slide not found."];
        }
    }

    // Update slide
    public function updateSlide($id, $title, $description, $link, $image, $order_number) {
        // Check if the slide exists
        $sql = "SELECT image FROM slides WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($slide) {
            // Handle image upload, if a new image is provided
            $imageFileName = $image ? basename($image["name"]) : $slide["image"];
            $targetDir = "images/";
            $targetFile = $targetDir . $imageFileName;
    
            if ($image && !move_uploaded_file($image["tmp_name"], $targetFile)) {
                return ["success" => false, "error" => "Image upload failed."];
            }
    
            // Update the slide data in the database
            $sql = "UPDATE slides SET title = :title, description = :description, link = :link, image = :image, order_number = :order_number WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":id" => $id,
                ":title" => $title,
                ":description" => $description,
                ":link" => $link,
                ":image" => $imageFileName,  // If no new image, it will retain the old image
                ":order_number" => $order_number
            ]);
    
            return ["success" => true];
        } else {
            return ["success" => false, "error" => "Slide not found."];
        }
    }
    

    // Get all slides
    public function getSlides() {
        $sql = "SELECT * FROM slides ORDER BY order_number ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
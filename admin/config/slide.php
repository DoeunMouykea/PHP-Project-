<?php
include 'db.php';

class Slide {
    private $conn; // Use $conn to match Database class property

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Insert a new slide into the database
    public function insertSlide($title, $description, $link, $image) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($image["name"]);

        // Move uploaded file to 'uploads' directory
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO slides (title, description, link, image) VALUES (:title, :description, :link, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":title" => $title,
                ":description" => $description,
                ":link" => $link,
                ":image" => $image["name"]
            ]);
            return ["success" => true];
        } else {
            return ["success" => false, "error" => "File upload failed."];
        }
    }

    // method for deleting a slide
    public function deleteSlide($id) {
        // Assuming you have a database connection
        $db = new Database();
        $connection = $db->getConnection();
        
        $query = "DELETE FROM slides WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
          return true;
        } else {
          return false;
        }
      }

    // Fetch all slides from the database
    public function getSlides() {
        $sql = "SELECT * FROM slides ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $slide = new Slide();

    if ($_POST["action"] == "insert") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $link = $_POST["link"];
        $image = $_FILES["image"];

        echo json_encode($slide->insertSlide($title, $description, $link, $image));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"])) {
    $slide = new Slide();

    if ($_GET["action"] == "fetch") {
        echo json_encode($slide->getSlides());
    }
}

// Handle deleting a slide
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
      $slideId = $_POST['id'];
      
      // Create an instance of Slide class
      $slide = new Slide();
      
      // Call delete method from Slide class
      $result = $slide->deleteSlide($slideId);
  
      // Return JSON response
      if ($result) {
        echo json_encode(['success' => true]);
      } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete slide.']);
      }
    }
  }
?>

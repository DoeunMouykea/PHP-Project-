<?php
require_once 'db.php'; // Include the database connection class

class Store {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function insertStore($meta_title, $meta_keywords, $email, $meta_description, $favicon, $logo, $store_icon) {
        $sql = "INSERT INTO store (meta_title, meta_keywords, email, meta_description, favicon, logo, store_icon) 
                VALUES (:meta_title, :meta_keywords, :email, :meta_description, :favicon, :logo, :store_icon)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':meta_title' => $meta_title,
            ':meta_keywords' => $meta_keywords,
            ':email' => $email,
            ':meta_description' => $meta_description,
            ':favicon' => $favicon,
            ':logo' => $logo,
            ':store_icon' => $store_icon
        ]);
    }

    // Method to fetch store data
    public function getStoreDetails() {
        $sql = "SELECT meta_title, meta_keywords, email, meta_description, favicon, logo, store_icon FROM store ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     // Method to add update data
     public function updateStoreDetails($id, $metaTitle, $metaKeywords, $email, $metaDescription) {
        $stmt = $this->conn->prepare("UPDATE store SET meta_title = ?, meta_keywords = ?, email = ?, meta_description = ? WHERE id = ?");
        return $stmt->execute([$metaTitle, $metaKeywords, $email, $metaDescription, $id]);
    }
}
?>

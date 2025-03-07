<?php
require_once 'db.php';

class Product {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Fetch products by type (genre/category)
    public function getProductsByType($type) {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE genre = :type");
        $stmt->execute([':type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all products
    public function getAllProducts() {
        $stmt = $this->conn->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch product by ID
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

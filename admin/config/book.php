<?php
require_once "db.php";

class Book {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Add a new book
    public function addBook($title, $author, $genre, $type, $price, $stock, $description, $image) {
        $sql = "INSERT INTO books (title, author, genre, type, price, stock, description, image) 
                VALUES (:title, :author, :genre, :type, :price, :stock, :description, :image)";
        $params = [
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':type' => $type,
            ':price' => $price,
            ':stock' => $stock,
            ':description' => $description,
            ':image' => $image
        ];
        return $this->db->runQuery($sql, $params);
    }

    // Get all books
    public function getBooks() {
        $sql = "SELECT * FROM books ORDER BY created_at ASC";
        return $this->db->runQuery($sql)->fetchAll();
    }

    // Get a single book by ID
    public function getBookById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        return $this->db->runQuery($sql, [':id' => $id])->fetch();
    }

    // Update a book
    public function updateBook($id, $title, $author, $genre, $type, $price, $stock, $description, $image) {
        $sql = "UPDATE books 
                SET title = :title, author = :author, genre = :genre, type = :type, 
                    price = :price, stock = :stock, description = :description, image = :image 
                WHERE id = :id";
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':type' => $type,
            ':price' => $price,
            ':stock' => $stock,
            ':description' => $description,
            ':image' => $image
        ];
        return $this->db->runQuery($sql, $params);
    }

    // Get books with discount
    public function getBooksWithDiscount() {
        $sql = "SELECT * FROM books WHERE discount_price > 0 ORDER BY created_at ASC";
        return $this->db->runQuery($sql)->fetchAll();
    }

    // Delete a book
    public function deleteBook($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        return $this->db->runQuery($sql, [':id' => $id]);
    }
}
?>

<?php
require_once "config/book.php";

if (isset($_GET['id'])) {
    $book = new Book();
    $bookId = $_GET['id'];

    // Fetch the book to delete the image file if exists
    $bookData = $book->getBookById($bookId);
    if ($bookData && !empty($bookData['image']) && file_exists($bookData['image'])) {
        unlink($bookData['image']); // Delete the image file
    }

    // Delete the book record
    if ($book->deleteBook($bookId)) {
        echo "<script>alert('Book deleted successfully!'); window.location.href='product.php';</script>";
    } else {
        echo "<script>alert('Error deleting book!'); window.location.href='product.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='product.php';</script>";
}
?>

<?php
require_once 'db.php'; // Ensure this file contains the Database class

class Cart {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Ensure the session is started
        }
    }

    public function addToCart($productId, $image, $name, $price) {
        // Check if the cart session is initialized
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product already exists in the cart
        $existingProductIndex = -1;
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $productId) {
                $existingProductIndex = $index;
                break;
            }
        }

        if ($existingProductIndex != -1) {
            // Update quantity if the product already exists
            $_SESSION['cart'][$existingProductIndex]['quantity'] += 1;
        } else {
            // Add new product to the cart
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $name,
                'image' => $image,
                'price' => $price,
                'quantity' => 1
            ];
        }
    }

    public function getCartCount() {
        if (isset($_SESSION['cart'])) {
            $count = 0;
            foreach ($_SESSION['cart'] as $item) {
                $count += $item['quantity'];
            }
            return $count;
        }
        return 0;
    }

    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }

    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['id'] == $productId) {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
                    break;
                }
            }
        }
    }

    public function updateQuantity($productId, $quantity) {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $productId) {
                    $item['quantity'] = max(1, $quantity); // Prevent zero or negative quantity
                    break;
                }
            }
        }
    }
}
?>

<?php
require_once 'db.php';

class Order {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Insert order into the 'orders' table
    public function createOrder($firstName, $lastName, $address, $city, $country, $zip, $phone, $totalAmount, $paymentMethod) {
        try {
            $query = "INSERT INTO orders (first_name, last_name, address, city, country, zip, phone, total_amount, payment_method)
                      VALUES (:first_name, :last_name, :address, :city, :country, :zip, :phone, :total_amount, :payment_method)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":first_name", $firstName);
            $stmt->bindParam(":last_name", $lastName);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":country", $country);
            $stmt->bindParam(":zip", $zip);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":total_amount", $totalAmount);
            $stmt->bindParam(":payment_method", $paymentMethod);

            $stmt->execute();
            
            return $this->conn->lastInsertId(); // Return last inserted order ID
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Insert order items into the 'order_items' table
    public function createOrderItems($orderId, $cartItems, $shippingCost) {
        try {
            $query = "INSERT INTO order_items (order_id, product_name, product_image, quantity, price, total, shipping_cost)
                      VALUES (:order_id, :product_name, :product_image, :quantity, :price, :total, :shipping_cost)";
            
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
            $stmt->bindParam(":product_name", $productName, PDO::PARAM_STR);
            $stmt->bindParam(":product_image", $productImage, PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":total", $total, PDO::PARAM_STR);
            $stmt->bindParam(":shipping_cost", $shippingCost, PDO::PARAM_STR);

            foreach ($cartItems as $item) {
                $productName = $item['name'];
                $productImage = $item['image'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $total = $price * $quantity;
                $shippingCost = $item['shipping_cost'] ?? $shippingCost; 
                $stmt->execute();
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    // Fetch all order items from the database
    public function getOrderItems() {
        try {
            $query = "SELECT * FROM order_items";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Fetch all orders from the database
    public function getOrders() {
        try {
            $query = "SELECT * FROM orders";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Fetch shipping cost for a specific order
    public function getShippingCost($orderId) {
        try {
            $query = "SELECT SUM(shipping_cost) AS total_shipping FROM order_items WHERE order_id = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_shipping'] ?? 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }


}
?>

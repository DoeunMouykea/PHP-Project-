<?php
require_once __DIR__ . '/db.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register($username, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        
        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    // Method to fetch all users
    public function getUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all user data
    }

    public function storeRememberToken($userId, $token) {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $query = "UPDATE " . $this->table_name . " SET remember_token = :token WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $hashedToken);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    public function getUserByToken($token) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE remember_token IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($token, $user['remember_token'])) {
                return $user;
            }
        }
        return false;
    }
    
}
?>

<?php
include_once 'admin/config/db.php';
require_once 'admin/config/product.php';
require_once 'admin/config/cart.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$product = new Product();
$cart = new Cart();
$sessionId = session_id(); // Unique session for each user

// Handling add to cart action
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $image = $_POST['image'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $cart->addToCart($productId, $image, $name, $price, $sessionId);
    header("Location: cart.php");
    exit();
}

// Get database instance
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch books with special offers from the database
$sql = "SELECT * FROM books WHERE discount_price IS NOT NULL ORDER BY id DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll();
?>

<section id="special-offer" class="py-5 my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header align-center">
                    <div class="title">
                        <span>Grab your opportunity</span>
                    </div>
                    <h2 class="section-title">Books with 50% Offer</h2>
                </div>

                <div class="product-list" data-aos="fade-up">
                    <div class="row">
                        <?php
                        if (!empty($books)) {
                            foreach ($books as $book) {
                                echo '<div class="col-md-3">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <img src="' . htmlspecialchars($book['image']) . '" alt="' . htmlspecialchars($book['title']) . '" class="product-item">
                                                 <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                                                </figure>
                                            <figcaption>
                                                <a href="product-detail.php?id=' . htmlspecialchars($book['id']) . '">
                                                    <h3>' . htmlspecialchars($book['title']) . '</h3>
                                                </a>
                                                <span>' . htmlspecialchars($book['author']) . '</span>
                                                <div class="item-price">';
                                if ($book['discount_price'] < $book['price']) {
                                    echo '<span class="prev-price">$' . number_format($book['price'], 2) . '</span>';
                                }
                                echo '$' . number_format($book['discount_price'], 2) . '</div>
                                                
                                                <form method="post" action="cart.php">
                                                    <input type="hidden" name="product_id" value="' . $book['id'] . '">
                                                    <input type="hidden" name="image" value="' . htmlspecialchars($book['image']) . '">
                                                    <input type="hidden" name="name" value="' . htmlspecialchars($book['title']) . '">
                                                    <input type="hidden" name="price" value="' . $book['discount_price'] . '">
                                                   
                                                </form>
                                            </figcaption>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo '<p>No special offer books available.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-wrap align-right">
                    <a href="index.php?f=store" class="btn-accent-arrow">View all products <i class="icon icon-ns-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

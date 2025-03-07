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
// Fetch the best-selling book from the database
$db = Database::getInstance();
$conn = $db->getConnection();
$sql = "SELECT * FROM books WHERE best_selling = 1 ORDER BY id ASC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$book = $stmt->fetch();
?>

<section id="best-selling" class="leaf-pattern-overlay">
    <div class="corner-pattern-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <?php if ($book): ?>
                        <div class="col-md-6">
                            <figure class="products-thumb">
                                <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="book" class="single-image">
                            </figure>
                        </div>

                        <div class="col-md-6">
                            <div class="product-entry">
                                <h2 class="section-title divider">Best Selling Book</h2>
                                <div class="products-content">
                                    <div class="author-name">By <?php echo htmlspecialchars($book['author']); ?></div>
                                    <h3 class="item-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['description']); ?></p>
                                    <div class="item-price">$ <?php echo number_format($book['price'], 2); ?></div>
                                    <div class="btn-wrap">
                                        <a href="product-detail.php?id=<?php echo $book['id']; ?>" class="btn-accent-arrow">
                                            Shop it now <i class="icon icon-ns-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No best-selling book available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

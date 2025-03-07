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

// Fetch featured books from database
$sql = "SELECT * FROM books WHERE featured = 1 ORDER BY id ASC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll();
?>

<section id="featured-books" class="py-5 my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header align-center">
					<div class="section-header align-center">
						<div class="title">
							<span>Some quality items</span>
						</div>
						<h2 class="section-title">Feature Books</h2>
					</div>
					<ul class="tabs">
						<li data-tab-target="#all-genre" class="active tab">All Genre</li>
						<li data-tab-target="#business" class="tab">Business</li>
						<li data-tab-target="#technology" class="tab">Technology</li>
						<li data-tab-target="#romantic" class="tab">Romantic</li>
						<li data-tab-target="#adventure" class="tab">Adventure</li>
						<li data-tab-target="#fictional" class="tab">Fictional</li>
					</ul>

				</div><!--inner-content-->
                </div>

                <div class="product-list" data-aos="fade-down">
                    <div class="row">
                        <?php
                        if (!empty($books)) {
                            foreach ($books as $book) {
                                echo '<div class="col-md-3">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <img src="' . htmlspecialchars($book['image']) . '" alt="Books" class="product-item">
                                                <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                                            </figure>
                                            <figcaption>
                                                <a href="product-detail.php?id=' . htmlspecialchars($book['id']) . '">
                                                    <h3>' . htmlspecialchars($book['title']) . '</h3>
                                                </a>
                                                <span>' . htmlspecialchars($book['author']) . '</span>
                                                <div class="item-price">$ ' . number_format($book['price'], 2) . '</div>
                                            </figcaption>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo '<p>No featured books available.</p>';
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

			
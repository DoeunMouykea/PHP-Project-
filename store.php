<?php
require_once 'admin/config/product.php';
require_once 'admin/config/cart.php';

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
    header("Location: index.php?f=cart");
    exit();
}

// Get the products based on the genre (filter type)
$bookType = isset($_GET['type']) ? $_GET['type'] : 'All';
if ($bookType === 'All') {
    $products = $product->getAllProducts();
} else {
    $products = $product->getProductsByType($bookType);
}

// Return filtered books based on the genre (AJAX response)
if (isset($_GET['type'])) {
    foreach ($products as $product): ?>
        <div class="col-md-3">
            <div class="product-item">
                <figure class="product-style">
                    <a href="product-detail.php?id=<?= $product['id'] ?>">
                        <img src="admin/<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="product-item">
                    </a>
                    <form action="store.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="image" value="<?= $product['image'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['title']) ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>
                </figure>
                <figcaption>
                    <h3><?= htmlspecialchars($product['title']) ?></h3>
                    <span><?= htmlspecialchars($product['author']) ?></span>
                    <div class="item-price">$ <?= number_format($product['price'], 2) ?></div>
                </figcaption>
            </div>
        </div>
    <?php endforeach;
    exit(); // Stop further script execution
}
?>


    <section id="popular-books" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center">
                        <div class="title"><span>Some quality items</span></div>
                        <h2 class="section-title">Books List</h2>
                    </div>

                    <!-- Genre Tabs -->
                    <ul class="tabs">
                        <li data-type="All" class="active tab">All Genre</li>
                        <li data-type="Business" class="tab">Business</li>
                        <li data-type="Technology" class="tab">Technology</li>
                        <li data-type="Romantic" class="tab">Romantic</li>
                        <li data-type="Adventure" class="tab">Adventure</li>
                        <li data-type="Fictional" class="tab">Fictional</li>
                        <li data-type="Novel" class="tab">Novel</li>
                        <li data-type="History" class="tab">History</li>
                    </ul>

                    <div id="book-list" class="tab-content">
                        <div id="all-genre" class="row">
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <figure class="product-style">
                                            <a href="product-detail.php?id=<?= $product['id'] ?>">
                                                <img src="admin/<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="product-item">
                                            </a>
                                            <form action="store.php" method="post">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="image" value="<?= $product['image'] ?>">
                                                <input type="hidden" name="name" value="<?= htmlspecialchars($product['title']) ?>">
                                                <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                                <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                                            </form>
                                        </figure>
                                        <figcaption>
                                            <h3><?= htmlspecialchars($product['title']) ?></h3>
                                            <span><?= htmlspecialchars($product['author']) ?></span>
                                            <div class="item-price">$ <?= number_format($product['price'], 2) ?></div>
                                        </figcaption>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
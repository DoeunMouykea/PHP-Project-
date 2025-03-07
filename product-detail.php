<?php
session_start();
include 'admin/config/product.php';

$productId = isset($_GET['id']) ? $_GET['id'] : 1; // Get product ID from URL (default to 1 if not set)

$product = new Product();
$productDetails = $product->getProductById($productId);
?>

<?php include 'components/head.php'; ?>
<?php include 'components/header.php'; ?>
    <section class="product-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-slider owl-carousel">
                        <div class="product-img">
                            <figure>
                                <img src="admin/<?= $productDetails['image'] ?>" alt="<?= $productDetails['title'] ?>">
                                <div class="p-status"><?= $productDetails['status'] ?> New</div>
                            </figure>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product-content">
                        <h2><?= $productDetails['title'] ?></h2>
                        <div class="pc-meta">
                            <h3>$<?= $productDetails['price'] ?></h3>
                            <div class="rating">
                                <?php
                                for ($i = 0; $i < $productDetails['rating']; $i++) {
                                    echo '<i class="fa fa-star"></i>';
                                }
                                ?>
                            </div>
                        </div>
                        <p><?= $productDetails['description'] ?></p>
                        <ul class="tags">
                            <li><span>Category: <?= $productDetails['type'] ?></span></li>
                        </ul>

                        <!-- Add to Cart Form -->
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= $productDetails['id'] ?>">
                            <input type="hidden" name="product_name" value="<?= $productDetails['title'] ?>">
                            <input type="hidden" name="product_price" value="<?= $productDetails['price'] ?>">
                            <input type="hidden" name="product_image" value="<?= $productDetails['image'] ?>">
                            <div class="product-quantity">
                                <div class="pro-qty">
                                    <input type="number" name="product_quantity" value="1" min="1">
                                </div>
                            </div>
                            <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                        </form>

                        <ul class="p-info">
                            <li>Product Information</li>
                            <li>Reviews</li>
                            <li>Product Care</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'; ?>
   
<?php

require_once 'admin/config/product.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];
    $productQuantity = max(1, (int)$_POST['product_quantity']);

    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $productQuantity;
            $found = true;
            break;
        }
    }

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'image' => $productImage,
            'quantity' => $productQuantity
        ];
    }

    header("Location: index.php?f=cart");
    exit;
}

// Handle removing an item
if (isset($_POST['remove_item'])) {
    $removeId = $_POST['remove_product_id'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($removeId) {
        return $item['id'] != $removeId;
    });
    header("Location: index.php?f=cart");
    exit;
}

// Handle updating quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $quantity) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = max(1, (int)$quantity);
            }
        }
    }
    // Redirect to store.php after updating the cart
    header("Location: index.php?f=store");
    exit;
}

// Calculate total quantity of items in the cart
$totalQuantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalQuantity += $item['quantity'];
}

// Set shipping cost based on total quantity or if the cart is empty
if ($totalQuantity <= 1) {
    $shippingCost = 0.00;
} elseif ($totalQuantity >= 5 && $totalQuantity <= 9) {
    $shippingCost = 1.00;
} else {
    $shippingCost = 2.00;
}

?>
<?php include 'components/head.php'; ?>
<section id="cart" class="cart py-5 my-5">

        <form method="post" action="cart.php">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            <?php $total = 0; ?>
                            <?php if (!empty($_SESSION['cart'])): ?>
                                <?php foreach ($_SESSION['cart'] as $item): ?>
                                    <tr>
                                        <td><img src="admin/<?= $item['image'] ?>" width="50"></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                        <td>
                                            <input type="number" style="width: 50px;" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1">
                                        </td>
                                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        <td>
                                            <form method="post" action="cart.php" style="display:inline;">
                                                <input type="hidden" name="remove_product_id" value="<?= $item['id'] ?>">
                                                <button type="submit" name="remove_item" class="remove-item-button">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Your cart is empty</td>
                                </tr>
                            <?php endif; ?>
                        </table>

                        <button type="submit" name="update_cart" class="update-cart-button">Update Cart</button>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">Subtotal:</span>
                            </div>
                            <div class="size-209">
                                <span class="mtext-110 cl2">$<?= number_format($total, 2) ?></span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">Shipping:</span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2">
                                $<?= number_format($shippingCost, 2) ?>
                                </p>
                            </div>
                        </div>

                        <?php $grandTotal = $total + $shippingCost; ?>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">Total:</span>
                            </div>
                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">$<?= number_format($grandTotal, 2) ?></span>
                            </div>
                        </div>

                        <a href="index.php?f=order" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </section>
    <?php include 'components/footer.php'; ?>
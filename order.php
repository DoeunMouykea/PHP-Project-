<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
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

// Calculate total price
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

$grandTotal = $total + $shippingCost;

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['order'] = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'address' => $_POST['address'] ?? '',
        'city' => $_POST['city'] ?? '',
        'country' => $_POST['country'] ?? '',
        'zip' => $_POST['zip'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'shipping_cost' => $shippingCost,  // Store shipping cost
        'total' => $grandTotal,
        'cart' => $_SESSION['cart'],
    ];
    

    $_SESSION['cart'] = [];

    header("Location: order_confirmation.php");
    exit;
}
?>


    <section class="cart-total-page spad">
        <div class="container">
            <form action="order_confirmation.php" method="post" class="checkout-form" enctype="multipart/form-data">
                <input type="hidden" name="total" value="<?= $grandTotal ?>">   
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Your Information</h3>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">Name*</p></div>
                            <div class="col-lg-5"><input type="text" name="first_name" placeholder="First Name" required></div>
                            <div class="col-lg-4"><input type="text" name="last_name" placeholder="Last Name" required></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">Street Address*</p></div>
                            <div class="col-lg-9"><input type="text" name="address" placeholder="Address" required></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">City*</p></div>
                            <div class="col-lg-9"><input type="text" name="city" placeholder="City" required></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">Country*</p></div>
                            <div class="col-lg-9"><input type="text" name="country" placeholder="Country" required></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">Post Code/ZIP*</p></div>
                            <div class="col-lg-9"><input type="number" name="zip" placeholder="ZIP Code" required></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><p class="in-name">Phone*</p></div>
                            <div class="col-lg-9"><input type="number" name="phone" placeholder="Phone Number" required></div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="payment-method">
                            <h3>Payment</h3>
                            <select class="form-select" name="payment_method" id="paymentMethod" required>
                                <option value="" selected disabled>Choose...</option>
                                <option value="paypal">PayPal</option>
                                <option value="qr_code">QR Code</option>
                                <option value="cod">Pay on Delivery</option>
                            </select>    
                        </div>

                        <!-- PayPal Button (Initially Hidden) -->
                        <div id="paypal-button-container" style="display: none; margin-top: 20px;">
                            <script src="https://www.paypal.com/sdk/js?client-id=ASakvCLhXSjnPdENg1czXogRr49U_euyerTDFmmna5_83uyePzValNT9KD1RqeUSGH3yJlkc4ycZ28TC&currency=USD"></script>
                            <div id="paypal-button"></div>
                            <script>
                                paypal.Buttons().render('#paypal-button');
                            </script>
                        </div>

                        <!-- QR Code Image + Upload Field (Initially Hidden) -->
                        <div id="qr-payment" style="display: none; margin-top: 20px;">
                            <h4>Scan to Pay</h4>
                            <img src="images/QRcode.png" width="200" alt="QR Code">
                            <p>Upload QR Payment :</p>
                            <input type="file" name="payment_successful" accept="image/*">
                        </div>

                    </div>
                    
                    <div class="col-lg-5">
                        <div class="order-table">
                            <h3 class="text-center">Order Summary</h3>                               
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <div class="cart-item">
                                    <h4><?= htmlspecialchars($item['name']) ?> <p> = <?= $item['quantity'] ?></p></h4> 
                                </div>   
                            <?php endforeach; ?>

                            <div class="cart-item"><span>Subtotal</span><p>$<?= number_format($total, 2) ?></p></div>
                            <div class="cart-item"><span>Shipping</span><p>$<?= number_format($shippingCost, 2) ?></p></div>
                            <div class="cart-total"><span>Total</span><p>$<?= number_format($grandTotal, 2) ?></p></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Place your order</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

  

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            let selectedMethod = this.value;
            document.getElementById('paypal-button-container').style.display = (selectedMethod === 'paypal') ? 'block' : 'none';
            document.getElementById('qr-payment').style.display = (selectedMethod === 'qr_code') ? 'block' : 'none';
        });
    </script>


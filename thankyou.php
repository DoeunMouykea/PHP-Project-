<?php
require_once 'admin/config/db.php';
require_once 'admin/config/order.php';

// Check if order ID is set in the session
if (!isset($_SESSION['order']['id'])) {
    header("Location: index.php");
    exit;
}

$orderId = $_SESSION['order']['id'];
$conn = Database::getInstance()->getConnection();

// Fetch order details
$query = "SELECT * FROM orders WHERE id = :order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit;
}

// Fetch order items
$query = "SELECT * FROM order_items WHERE order_id = :order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
$stmt->execute();
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;
foreach ($orderItems as $item) {
    $subtotal += $item['total'];
}

$orderClass = new Order();
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

$grandTotal = $subtotal + $shippingCost;


$sellerCompany = "Book Store";
$sellerAddress = "Downtown, Phnom Penh";
$sellerCity = "Phnom Penh, Cambodia";
$sellerPhone = "085378162 / 0889390038";
$sellerEmail = "bookstore@gmail.com";
?>
<div class="container invoice-container">
    <div class="invoice-header text-center"><h3>INVOICE</h3></div>
    <div class="invoice-details">
    <p><strong>Invoice No:</strong> <?= htmlspecialchars($orderId) ?></p>
    <p><strong>Invoice Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
    <p><strong>Due Date:</strong> <?= date("Y-m-d", strtotime($order['created_at'] . "+7 days")) ?></p>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 mb-5">
            <h4 class="mb-2"><strong>FROM COMPANY</strong></h4>
            <p>
                NAME : <?= htmlspecialchars($sellerCompany) ?><br>
                ADDRESS : <?= htmlspecialchars($sellerAddress) ?><br>
                COUNTRY : <?= htmlspecialchars($sellerCity) ?><br>
                CONTACT US : <?= htmlspecialchars($sellerPhone) ?><br>
                EMAIL : <?= htmlspecialchars($sellerEmail) ?>
            </p>
        </div>
        <div class="col-md-6">
            <h4 class="mb-2"><strong>TO CUSTOMER</strong></h4>
            <p> NAME :  <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?><br>
                ADDRESS : <?= htmlspecialchars($order['address']) ?><br>
                COUNTRY : <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['country']) ?> - <?= htmlspecialchars($order['zip']) ?><br>
                PHONE  : <?= htmlspecialchars($order['phone']) ?><br>
                PAYMENT BY : <?= htmlspecialchars($order['payment_method']) ?>

            </p>
        </div>
    </div>
    <table class="table invoice-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>$<?= number_format($item['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="text-end"><strong>Subtotal : </strong></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end"><strong>Shipping : </strong></td>
                <td>$<?= number_format($shippingCost, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end"><strong>Total : </strong></td>
                <td>$<?= number_format($grandTotal, 2) ?></td>
            </tr>
        </tbody>
    </table>
    <div class="text-center mt-4">
        <p><strong>Thank you for your purchase!</strong></p>
        <a href="index.php" class="btn btn-primary">Return to Store</a>
    </div>
</div>

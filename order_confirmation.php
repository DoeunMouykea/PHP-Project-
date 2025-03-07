<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'admin/config/db.php';
require_once 'admin/config/order.php';

// Telegram Bot Token and Chat ID
$botToken = '7643893080:AAH5Lg9e6Qcc1JdTBZ0p_Ja4NwB_YGvICT8';
$chatId = '1288833458';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve order details safely
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $totalAmount = isset($_POST['total']) ? floatval($_POST['total']) : 0;
    $shippingCost = isset($_POST['shipping_cost'])? floatval($_POST['shipping_cost']) : 0;
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    // Validate required fields
    if ($totalAmount <= 0) {
        die("Invalid total amount.");
    }
    if (empty($paymentMethod)) {
        die("Please select a payment method.");
    }

    // Handle QR Code payment image upload
    $qrPaymentImage = null;
    if ($paymentMethod === 'qr_code' && isset($_FILES['payment_successful'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['payment_successful']['name']);
        $targetFilePath = $uploadDir . time() . "_" . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES['payment_successful']['tmp_name'], $targetFilePath)) {
                $qrPaymentImage = $targetFilePath;
            } else {
                die("Error uploading the QR payment image.");
            }
        } else {
            die("Invalid file type.");
        }
    }

    // Get shipping cost
    $shippingCost = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $shippingCost += $item['shipping_cost'] ?? 0;
        }
    }

    // Create order
    $order = new Order();
    $orderId = $order->createOrder($firstName, $lastName, $address, $city, $country, $zip, $phone, $totalAmount, $paymentMethod);

    if ($orderId) {
        $_SESSION['order'] = [
            'id' => $orderId,
            'total' => $totalAmount,
            'payment_method' => $paymentMethod,
            'qr_payment_image' => $qrPaymentImage,
            'shipping_cost' => $shippingCost
        ];

        if (!empty($_SESSION['cart'])) {
            $order->createOrderItems($orderId, $_SESSION['cart'], $shippingCost);
        }

        // Prepare Telegram message
        $message = "📦 *New Order Received!*\n";
        $message .= "🆔 Order ID: *$orderId*\n";
        $message .= "👤 Name: *$firstName $lastName*\n";
        $message .= "🏠 Address: *$address, $city, $country, $zip*\n";
        $message .= "📞 Phone: *$phone*\n";
        $message .= "💰 Total Amount: *$" . number_format($totalAmount, 2) . "*\n";
        $message .= "💳 Payment Method: *$paymentMethod*\n";
        $message .= "🚚 Shipping Cost: *$" . number_format($shippingCost, 2) . "*\n\n";
        $message .= "🛍 *Order Items:*\n";

        // Check if cart exists before looping
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $message .= " - " . htmlspecialchars($item['name']) . " x" . htmlspecialchars($item['quantity']) . " = $" . number_format($item['price'] * $item['quantity'], 2) . "\n";
            }
        } else {
            $message .= "❌ No items found in the cart.\n";
        }

        // Send to Telegram
        $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ]
        ];
        $context  = stream_context_create($options);
        file_get_contents($telegramUrl, false, $context);

        // ✅ Clear cart AFTER sending Telegram message
        $_SESSION['cart'] = [];
        session_write_close(); // Ensure session data is saved

        // Redirect to thank you page
        header("Location: index.php?f=thankyou");
        exit;
    } else {
        die("There was an error processing your order.");
    }
}
?>

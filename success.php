<?php
$order_id = htmlspecialchars($_GET['id'] ?? '0000');
$customer_name = htmlspecialchars($_GET['name'] ?? 'Guest');
$flavor_name = htmlspecialchars($_GET['flavor'] ?? 'your favorite scoop');
$total_amount = floatval($_GET['total'] ?? 0);
$payment_method = htmlspecialchars($_GET['payment'] ?? 'Cash on Delivery');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Scoop Heaven</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <main class="success-page">
        <div class="success-confetti" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <section class="success-card">
            <div class="success-badge" aria-hidden="true">
                <i class='bx bx-check'></i>
            </div>

            <h1>Order Confirmed!</h1>
            <p class="success-message">
                Thank you, <strong><?php echo $customer_name; ?></strong>! Your
                <strong><?php echo $flavor_name; ?></strong> is being freshly prepared and will be on its way soon.
            </p>

            <div class="order-details">
                <h2>Your Order Details</h2>

                <div class="detail-row">
                    <span class="detail-label">Order ID</span>
                    <span class="detail-value">#SH-<?php echo $order_id; ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">Rs. <?php echo number_format($total_amount, 2); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value"><?php echo $payment_method; ?></span>
                </div>
            </div>

            <div class="success-actions">
                <a href="index.php" class="success-home-btn">
                    <i class='bx bx-home-heart'></i>
                    Back to Home
                </a>
            </div>
        </section>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>
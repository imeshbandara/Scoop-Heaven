<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

include('config/db.php');
include('includes/header.php');

// Always source checkout from the session cart.
// Backwards compatibility: if someone still hits the old URL
// checkout.php?flavor=...&price=...&image=..., we convert that into a
// 1-item session cart (only when cart is empty).
if (isset($_GET['flavor'], $_GET['price'])) {
    $selected_flavor = (string)($_GET['flavor'] ?? '');
    $price = (float)($_GET['price'] ?? 0);
    $image_path = !empty($_GET['image']) ? (string)urldecode($_GET['image']) : 'asset/main.png';

    if ($selected_flavor !== '' && $price > 0) {
        $lookupRow = null;
        $lookupStmt = mysqli_prepare($conn, "SELECT id, price, image_path FROM flavors WHERE name = ? LIMIT 1");
        if ($lookupStmt) {
            mysqli_stmt_bind_param($lookupStmt, "s", $selected_flavor);
            if (mysqli_stmt_execute($lookupStmt)) {
                $lookupRes = mysqli_stmt_get_result($lookupStmt);
                $lookupRow = $lookupRes ? mysqli_fetch_assoc($lookupRes) : null;
            }
            mysqli_stmt_close($lookupStmt);
        }

        $flavorId = (int)($lookupRow['id'] ?? 0);
        $unitPrice = (float)($lookupRow['price'] ?? $price);
        $img = (string)($lookupRow['image_path'] ?? $image_path);

        if ($flavorId <= 0) {
            $flavorId = (int)abs(crc32($selected_flavor));
        }

        if ($img !== '' && strpos($img, '/') === false) {
            $img = 'asset/' . $img;
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $key = (string)$flavorId;
        if (!isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key] = [
                'id' => (int)$flavorId,
                'name' => $selected_flavor,
                'price' => $unitPrice,
                'quantity' => 1,
                'image' => $img,
            ];
        } else {
            $_SESSION['cart'][$key]['quantity'] = (int)($_SESSION['cart'][$key]['quantity'] ?? 0) + 1;
        }
    }
}

$cart = $_SESSION['cart'] ?? [];
$cartItems = is_array($cart) ? array_values($cart) : [];
$cartCount = 0;
$subtotal = 0.0;

foreach ($cartItems as $item) {
    $cartCount += (int)($item['quantity'] ?? 0);
    $subtotal += ((float)($item['price'] ?? 0)) * ((int)($item['quantity'] ?? 0));
}

$grandTotal = $subtotal;
$firstItem = $cartItems[0] ?? null;
$selected_flavor = $firstItem ? (string)($firstItem['name'] ?? '') : 'Ice Cream';
$price = $firstItem ? (float)($firstItem['price'] ?? 0) : 0;
$image_path = $firstItem ? (string)($firstItem['image'] ?? 'asset/main.png') : 'asset/main.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Scoop Heaven</title>
    
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    
    <link rel="stylesheet" href="style.css">
    
</head>
<body>



<div class="checkout-container">
    <div class="checkout-grid">
        
        <section class="checkout-panel">
            <div class="checkout-intro">
                <h2>Complete Your Order</h2>
                <p>Enter your details and we'll handle the rest.</p>
            </div>

            <form action="process_order.php" method="POST" class="checkout-form">

                <div class="input-group">
                    <input type="text" name="cust_name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <input type="text" name="cust_phone" placeholder="Phone Number" required>
                </div>

                <div class="input-group">
                    <textarea name="cust_address" placeholder="Delivery Address" rows="3" required></textarea>
                </div>

                <button type="submit" name="place_order" class="confirm-btn">Confirm & Pay (COD)</button>
            </form>
        </section>

        <aside class="summary-panel">
            <div class="hero-card" style="background-image: url('<?php echo htmlspecialchars($image_path); ?>'); background-size: cover; height: 200px; border-radius: 15px; position: relative; display: flex; align-items: flex-end; padding: 20px; color: white;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); border-radius: 15px;"></div>
                <h3 style="position: relative; z-index: 2;">
                    <?php echo empty($cartItems) ? 'Your Cart' : (count($cartItems) > 1 ? 'Mixed Flavors' : htmlspecialchars($selected_flavor)); ?>
                </h3>
            </div>

            <div class="summary-card" style="margin-top: 20px;">
                <p>Items in cart: <strong><?php echo (int)$cartCount; ?></strong></p>
                <h3 style="color: var(--main-color); margin-top: 10px;">
                    Total Amount: Rs. <span><?php echo number_format($grandTotal, 2); ?></span>
                </h3>

                <?php if (empty($cartItems)): ?>
                    <p style="margin-top: 10px; color: #666;">Your cart is empty.</p>
                <?php endif; ?>
            </div>
        </aside>

    </div>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

$cart = $_SESSION['cart'] ?? [];

// Totals for initial render (AJAX updates will replace values client-side).
$subtotal = 0.0;
foreach ($cart as $item) {
    $subtotal += ((float)($item['price'] ?? 0)) * ((int)($item['quantity'] ?? 0));
}
$grandTotal = $subtotal;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Scoop Heaven</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="cart-page">
        <div class="cart-container">
            <div class="heading">
                <h2>Your Shopping Cart</h2>
            </div>

            <?php if (empty($cart)): ?>
                <p style="text-align:center; margin-top: 1rem;">Your cart is empty.</p>
                <div style="text-align:center; margin-top: 1rem;">
                    <a href="index.php" class="btn" style="padding: 10px 28px;">Continue shopping</a>
                </div>
            <?php else: ?>
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th style="width: 190px;">Quantity</th>
                                <th>Line Total</th>
                                <th style="width: 90px;">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-body">
                            <?php foreach ($cart as $item): ?>
                                <?php
                                $id = (int)($item['id'] ?? 0);
                                $name = (string)($item['name'] ?? '');
                                $price = (float)($item['price'] ?? 0);
                                $qty = (int)($item['quantity'] ?? 0);
                                $image = (string)($item['image'] ?? '');
                                $lineTotal = $price * $qty;
                                ?>
                                <tr data-id="<?php echo $id; ?>">
                                    <td>
                                        <div class="cart-item">
                                             <img class="cart-item__img" src="<?php echo htmlspecialchars($image); ?>" alt="" loading="lazy" onerror="this.onerror=null; this.src='asset/main.png';">
                                            <div class="cart-item__meta">
                                                <div class="cart-item__name"><?php echo htmlspecialchars($name); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rs. <?php echo number_format($price, 2); ?></td>
                                    <td>
                                        <div class="cart-qty">
                                            <button class="cart-qty-btn qty-minus" type="button" data-action="decrement" data-id="<?php echo $id; ?>" data-quantity="<?php echo $qty; ?>" aria-label="Decrease quantity">-</button>
                                            <span class="cart-qty-value"><?php echo $qty; ?></span>
                                            <button class="cart-qty-btn qty-plus" type="button" data-action="increment" data-id="<?php echo $id; ?>" data-quantity="<?php echo $qty; ?>" aria-label="Increase quantity">+</button>
                                        </div>
                                    </td>
                                    <td class="cart-line-total">Rs. <?php echo number_format($lineTotal, 2); ?></td>
                                    <td>
                                        <button class="cart-remove-btn" type="button" data-id="<?php echo $id; ?>" aria-label="Remove item">Remove</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-totals">
                    <div class="cart-total-row">
                        <span>Subtotal</span>
                        <strong id="cart-subtotal">Rs. <?php echo number_format($subtotal, 2); ?></strong>
                    </div>
                    <div class="cart-total-row">
                        <span>Grand Total</span>
                        <strong id="cart-grand-total">Rs. <?php echo number_format($grandTotal, 2); ?></strong>
                    </div>
                </div>

                <div class="cart-actions">
                    <a href="index.php#products" class="btn" style="padding: 10px 28px;">Add more flavors</a>
                    <a href="checkout.php" class="btn" style="padding: 10px 28px;">Checkout</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Cart quantity/remove AJAX handlers live in script.js, but cart.php needs the table update targets.
        window.__SCOOP_CART_PAGE__ = true;
    </script>
</body>
</html>


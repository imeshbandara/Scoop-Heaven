<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)($item['quantity'] ?? 0);
    }
}
?>

<header class="site-header">
    <a href="index.php" class="brand">
        <img src="logo.png" alt="Scoop Heaven">
        <span class="brand-text">SCOOP HEAVEN</span>
    </a>

    <!-- Menu icon (mobile) -->
    <i class='bx bx-menu' id="menu-icon" aria-label="Open menu" role="button" tabindex="0"></i>

    <!-- Center links -->
    <ul class="navbar" aria-label="Primary navigation">
        <li><a href="index.php#home">Home</a></li>
        <li><a href="index.php#about">Our Story</a></li>
        <li><a href="index.php#our-service">Our Service</a></li>
        <li><a href="index.php#products">Flavors</a></li>
        <li><a href="index.php#custormers">Reviews</a></li>

        <!-- Mobile-only actions -->
        <li class="mobile-only"><a href="track_order.php">Track Order</a></li>
        <li class="mobile-only"><a href="index.php#products">Scoop Up</a></li>
    </ul>

    <!-- Right side actions -->
    <div class="nav-right">
        <div class="nav-actions desktop-only">
            <a href="track_order.php" class="nav-action-link">Track Order</a>
            <a href="index.php#products" class="nav-cta">Scoop Up</a>
        </div>

        <div class="header-icon" aria-label="Header actions">
            <i class='bx bx-moon' id="dark-mode-toggle" aria-label="Toggle dark mode" role="button" tabindex="0"></i>
            <a href="cart.php" class="cart-link" aria-label="Cart" role="button" tabindex="0">
                <i class='bx bx-cart' aria-hidden="true"></i>
                <span id="cart-count" class="cart-count-badge"><?php echo (int)$cartCount; ?></span>
            </a>
            <i class='bx bx-search' id="search-icon" aria-label="Search" role="button" tabindex="0"></i>
        </div>
    </div>

    <!-- search-box -->
    <div class="search-box">
        <input type="search" id="flavor-search" placeholder="Search for a flavor (e.g. Chocolate)...">
    </div>
</header>
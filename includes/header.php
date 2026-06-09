<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
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

<!-- Cart Sidebar Overlay -->
<div class="cart-overlay" id="cart-overlay"></div>

<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cart-sidebar">
    <div class="cart-sidebar-header">
        <h2>Your <span>Cart</span></h2>
        <i class='bx bx-x close-cart' id="close-cart" role="button" aria-label="Close cart"></i>
    </div>
    
    <div class="cart-sidebar-body" id="cart-sidebar-body">
        <!-- Rendered dynamically -->
    </div>
    
    <div class="cart-sidebar-footer">
        <div class="cart-total-row">
            <span class="total-label">Grand Total:</span>
            <span class="total-value" id="cart-sidebar-total">Rs. 0.00</span>
        </div>
        <a href="checkout.php" class="checkout-btn disabled" id="cart-checkout-btn">Proceed to Checkout</a>
    </div>
</div>

<script>
(function() {
    const cartLink = document.querySelector('.cart-link');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const closeCartBtn = document.getElementById('close-cart');
    const cartSidebarBody = document.getElementById('cart-sidebar-body');
    const cartSidebarTotal = document.getElementById('cart-sidebar-total');
    const cartCheckoutBtn = document.getElementById('cart-checkout-btn');

    // Sidebar toast helper
    function showSidebarToast(message) {
        let toast = document.querySelector('.cart-sidebar-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'toast cart-sidebar-toast';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(window.__sidebarToastTimeout);
        window.__sidebarToastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }

    // Export helpers globally
    window.openCartSidebar = function() {
        if (cartSidebar && cartOverlay) {
            cartSidebar.classList.add('active');
            cartOverlay.classList.add('active');
            fetchSidebarCart();
        }
    };

    window.closeCartSidebar = function() {
        if (cartSidebar && cartOverlay) {
            cartSidebar.classList.remove('active');
            cartOverlay.classList.remove('active');
        }
    };

    window.fetchSidebarCart = async function() {
        try {
            const response = await fetch('cart_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get' })
            });
            const data = await response.json();
            if (data && data.success) {
                renderSidebarCart(data);
            }
        } catch (error) {
            console.error('Error fetching cart:', error);
        }
    };

    function renderSidebarCart(data) {
        // Update navbar count badge on the page
        const cartCountBadge = document.getElementById('cart-count');
        if (cartCountBadge) {
            cartCountBadge.textContent = data.cartCount;
        }

        // Render items inside the scrollable container
        if (!cartSidebarBody) return;
        cartSidebarBody.innerHTML = '';
        const items = data.items || [];

        if (items.length === 0) {
            cartSidebarBody.innerHTML = `
                <div class="cart-sidebar-empty">
                    <i class='bx bx-cart-alt'></i>
                    <p>Your cart is empty</p>
                </div>
            `;
            if (cartSidebarTotal) cartSidebarTotal.textContent = 'Rs. 0.00';
            if (cartCheckoutBtn) {
                cartCheckoutBtn.classList.add('disabled');
                cartCheckoutBtn.setAttribute('href', '#');
                cartCheckoutBtn.style.pointerEvents = 'none';
            }
        } else {
            items.forEach(item => {
                const itemEl = document.createElement('div');
                itemEl.className = 'cart-sidebar-item';
                itemEl.setAttribute('data-id', item.id);

                const priceNum = Math.round(parseFloat(item.price ?? 0) * 100) / 100;

                itemEl.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="cart-sidebar-item-img" loading="lazy" onerror="this.onerror=null; this.src='asset/main.png';">
                    <div class="cart-sidebar-item-info">
                        <h4 class="cart-sidebar-item-name">${item.name}</h4>
                        <span class="cart-sidebar-item-price">Rs. ${priceNum.toFixed(2)}</span>
                        <div class="cart-sidebar-qty">
                            <button type="button" class="qty-btn qty-minus" data-id="${item.id}" data-quantity="${item.quantity}">-</button>
                            <span class="qty-val">${item.quantity}</span>
                            <button type="button" class="qty-btn qty-plus" data-id="${item.id}" data-quantity="${item.quantity}">+</button>
                        </div>
                    </div>
                    <button type="button" class="cart-sidebar-item-remove" data-id="${item.id}" aria-label="Remove item">
                        <i class='bx bx-trash'></i>
                    </button>
                `;
                cartSidebarBody.appendChild(itemEl);
            });

            const grandTotalNum = Math.round(parseFloat(data.grandTotal ?? 0) * 100) / 100;
            if (cartSidebarTotal) cartSidebarTotal.textContent = `Rs. ${grandTotalNum.toFixed(2)}`;
            if (cartCheckoutBtn) {
                cartCheckoutBtn.classList.remove('disabled');
                cartCheckoutBtn.setAttribute('href', 'checkout.php');
                cartCheckoutBtn.style.pointerEvents = 'auto';
            }
        }
    }

    async function postCartAction(payload) {
        try {
            const res = await fetch('cart_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            return await res.json();
        } catch (error) {
            console.error('Error posting cart action:', error);
            return { success: false, message: 'Network error. Please try again.' };
        }
    }

    // Event listeners
    if (cartLink) {
        cartLink.addEventListener('click', (e) => {
            e.preventDefault();
            window.openCartSidebar();
        });
    }

    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', () => {
            window.closeCartSidebar();
        });
    }

    if (cartOverlay) {
        cartOverlay.addEventListener('click', () => {
            window.closeCartSidebar();
        });
    }

    // Delegated click handler inside sidebar body
    if (cartSidebarBody) {
        cartSidebarBody.addEventListener('click', async (e) => {
            // Handle Plus/Minus
            const qtyBtn = e.target.closest('.qty-btn');
            if (qtyBtn) {
                const id = qtyBtn.dataset.id;
                const currentQty = parseInt(qtyBtn.dataset.quantity);
                const isPlus = qtyBtn.classList.contains('qty-plus');
                const newQty = isPlus ? currentQty + 1 : currentQty - 1;

                const response = await postCartAction({
                    action: 'update',
                    id: id,
                    quantity: newQty
                });

                if (response && response.success) {
                    renderSidebarCart(response);
                    showSidebarToast(response.message || 'Cart updated.');
                    
                    const mainCartTbody = document.getElementById('cart-items-body');
                    if (mainCartTbody && window.__SCOOP_CART_PAGE__) {
                        location.reload();
                    }
                } else {
                    showSidebarToast(response.message || 'Unable to update cart.');
                }
                return;
            }

            // Handle Remove Button
            const removeBtn = e.target.closest('.cart-sidebar-item-remove');
            if (removeBtn) {
                const id = removeBtn.dataset.id;

                const response = await postCartAction({
                    action: 'remove',
                    id: id
                });

                if (response && response.success) {
                    renderSidebarCart(response);
                    showSidebarToast(response.message || 'Item removed.');

                    const mainCartTbody = document.getElementById('cart-items-body');
                    if (mainCartTbody && window.__SCOOP_CART_PAGE__) {
                        location.reload();
                    }
                } else {
                    showSidebarToast(response.message || 'Unable to remove item.');
                }
            }
        });
    }
})();
</script>

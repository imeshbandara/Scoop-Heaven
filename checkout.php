<?php include('includes/header.php'); ?>
<?php include('config/db.php'); ?>

<?php 
$selected_flavor = $_GET['flavor'] ?? 'Ice Cream';
$price = floatval($_GET['price'] ?? 0);
$image_path = !empty($_GET['image']) ? urldecode($_GET['image']) : '';
$flavor_safe = mysqli_real_escape_string($conn, $selected_flavor);

if (empty($image_path)) {
    $sql = "SELECT image_path FROM flavors WHERE name = '$flavor_safe' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['image_path'])) {
            $image_path = $row['image_path'];
        }
    }
}

if (empty($image_path)) {
    $image_path = 'asset/main.png';
}

$accent = '#ff7eb9';
$accentSoft = '#fff0f3';
$accentDeep = '#c72b5a';

if (stripos($selected_flavor, 'choco') !== false || stripos($selected_flavor, 'coffee') !== false || stripos($selected_flavor, 'caramel') !== false) {
    $accent = '#8b5e3c';
    $accentSoft = '#f9efe3';
    $accentDeep = '#5b3a24';
} elseif (stripos($selected_flavor, 'strawberry') !== false || stripos($selected_flavor, 'berry') !== false) {
    $accent = '#ff6f92';
    $accentSoft = '#fff0f6';
    $accentDeep = '#a32b5c';
} elseif (stripos($selected_flavor, 'mint') !== false || stripos($selected_flavor, 'pistachio') !== false) {
    $accent = '#5bb39f';
    $accentSoft = '#ebf9f5';
    $accentDeep = '#2f7a6a';
} elseif (stripos($selected_flavor, 'vanilla') !== false || stripos($selected_flavor, 'mango') !== false || stripos($selected_flavor, 'lemon') !== false) {
    $accent = '#f2ba57';
    $accentSoft = '#fff4d9';
    $accentDeep = '#b07832';
} elseif (stripos($selected_flavor, 'matcha') !== false || stripos($selected_flavor, 'green') !== false) {
    $accent = '#7bae6a';
    $accentSoft = '#eaf7e7';
    $accentDeep = '#4f7f45';
}

$hero_image = htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8');
?>

<div class="checkout-container" style="--accent: <?php echo $accent; ?>; --accent-soft: <?php echo $accentSoft; ?>; --accent-deep: <?php echo $accentDeep; ?>;">
    <div class="checkout-grid">
        <section class="checkout-panel">
            <div class="checkout-intro">
                <span class="eyebrow">Delivery details</span>
                <h2>Complete your order</h2>
                <p class="intro-copy">A premium checkout experience for Scoop Heaven. Enter your delivery details and watch the flavor-forward summary adapt to your selected scoop.</p>
            </div>

            <form action="process_order.php" method="POST" class="checkout-form">
                <input type="hidden" name="flavor_name" value="<?php echo htmlspecialchars($selected_flavor, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">

                <div class="input-group">
                    <i class='bx bx-user'></i>
                    <input type="text" name="cust_name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class='bx bx-phone'></i>
                    <input type="text" name="cust_phone" placeholder="Phone Number" required>
                </div>

                <div class="input-group textarea-group">
                    <i class='bx bx-map'></i>
                    <textarea name="cust_address" placeholder="Delivery Address" required></textarea>
                </div>

                <div class="quantity-section">
                    <label for="qty">Quantity</label>
                    <input type="number" name="quantity" id="qty" value="1" min="1" onchange="calculateTotal()">
                </div>

                <button type="submit" name="place_order" class="confirm-btn">Confirm & Pay (COD)</button>
            </form>
        </section>

        <aside class="summary-panel">
            <div class="hero-card" style="background-image: url('<?php echo $hero_image; ?>');">
                <div class="hero-layer"></div>
                <div class="hero-label">Your Scoop</div>
                <h3><?php echo htmlspecialchars($selected_flavor, ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="hero-subtitle">Premium scoop presentation with a flavor-tailored ambiance.</p>
            </div>

            <div class="summary-card">
                <div class="summary-row">
                    <span>Flavor</span>
                    <strong><?php echo htmlspecialchars($selected_flavor, ENT_QUOTES, 'UTF-8'); ?></strong>
                </div>
                <div class="summary-row">
                    <span>Unit Price</span>
                    <strong>Rs. <?php echo number_format($price, 2); ?></strong>
                </div>
                <div class="summary-row total-row">
                    <span>Total</span>
                    <strong>Rs. <span id="display_total"><?php echo number_format($price, 2); ?></span></strong>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
function calculateTotal() {
    const unitPrice = <?php echo $price; ?>;
    let qty = Number(document.getElementById('qty').value);
    if (qty < 1) {
        qty = 1;
        document.getElementById('qty').value = 1;
    }
    document.getElementById('display_total').innerText = (unitPrice * qty).toFixed(2);
}
</script>

<?php include('includes/footer.php'); ?>
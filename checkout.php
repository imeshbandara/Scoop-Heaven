<?php 
include('config/db.php'); 
include('includes/header.php'); 

$selected_flavor = $_GET['flavor'] ?? 'Ice Cream';
$price = floatval($_GET['price'] ?? 0);
$image_path = !empty($_GET['image']) ? urldecode($_GET['image']) : 'asset/main.png';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"> </head>
<body>

<div class="checkout-container">
    <div class="checkout-grid">
        
        <section class="checkout-panel">
            <div class="checkout-intro">
                <h2>Complete Your Order</h2>
                <p>Enter your details and we'll handle the rest.</p>
            </div>

            <form action="process_order.php" method="POST" class="checkout-form">
                <input type="hidden" name="flavor_name" value="<?php echo htmlspecialchars($selected_flavor); ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">

                <div class="input-group">
                    <input type="text" name="cust_name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <input type="text" name="cust_phone" placeholder="Phone Number" required>
                </div>

                <div class="input-group">
                    <textarea name="cust_address" placeholder="Delivery Address" rows="3" required></textarea>
                </div>

                <div class="quantity-section" style="margin-top:20px;">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" id="qty" value="1" min="1" onchange="calculateTotal()" style="width: 60px; padding: 5px;">
                </div>

                <button type="submit" name="place_order" class="confirm-btn">Confirm & Pay (COD)</button>
            </form>
        </section>

        <aside class="summary-panel">
            <div class="hero-card" style="background-image: url('<?php echo $image_path; ?>'); background-size: cover; height: 200px; border-radius: 15px; position: relative; display: flex; align-items: flex-end; padding: 20px; color: white;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); border-radius: 15px;"></div>
                <h3 style="position: relative; z-index: 2;"><?php echo htmlspecialchars($selected_flavor); ?></h3>
            </div>

            <div class="summary-card" style="margin-top: 20px;">
                <p>Unit Price: <strong>Rs. <?php echo number_format($price, 2); ?></strong></p>
                <h3 style="color: var(--main-color); margin-top: 10px;">Total Amount: Rs. <span id="display_total"><?php echo number_format($price, 2); ?></span></h3>
            </div>
        </aside>

    </div>
</div>

<script>
function calculateTotal() {
    const unitPrice = <?php echo $price; ?>;
    let qty = document.getElementById('qty').value;
    document.getElementById('display_total').innerText = (unitPrice * qty).toFixed(2);
}
</script>

<?php include('includes/footer.php'); ?>
</body>
</html>
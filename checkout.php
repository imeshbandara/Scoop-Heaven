<?php include('includes/header.php'); ?>
<?php include('config/db.php'); ?>

<div class="checkout-container">
    <div class="checkout-box">
        <h2>Complete Your Order</h2>
        
        <?php 
        $selected_flavor = $_GET['flavor'] ?? 'Ice Cream';
        $price = $_GET['price'] ?? 0;
        ?>

        <div class="order-summary">
            <p>Product: <strong><?php echo $selected_flavor; ?></strong></p>
            <p>Unit Price: <strong>Rs. <?php echo $price; ?>.00</strong></p>
        </div>

        <form action="process_order.php" method="POST" class="checkout-form">
            <input type="hidden" name="flavor_name" value="<?php echo $selected_flavor; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">

            <div class="input-group">
                <i class='bx bx-user'></i>
                <input type="text" name="cust_name" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <i class='bx bx-phone'></i>
                <input type="text" name="cust_phone" placeholder="Phone Number" required>
            </div>

            <div class="input-group">
                <i class='bx bx-map'></i>
                <textarea name="cust_address" placeholder="Delivery Address" required></textarea>
            </div>

            <div class="quantity-section">
                <label>Quantity:</label>
                <input type="number" name="quantity" id="qty" value="1" min="1" onchange="calculateTotal()">
            </div>

            <div class="total-display">
                <span>Total Amount:</span>
                <span class="price">Rs. <span id="display_total"><?php echo $price; ?></span>.00</span>
            </div>

            <button type="submit" name="place_order" class="confirm-btn">Confirm & Pay (COD)</button>
        </form>
    </div>
</div>

<script>
function calculateTotal() {
    let price = <?php echo $price; ?>;
    let qty = document.getElementById('qty').value;
    if(qty < 1) { document.getElementById('qty').value = 1; qty = 1; }
    document.getElementById('display_total').innerText = (price * qty).toFixed(2);
}
</script>

<?php include('includes/footer.php'); ?>
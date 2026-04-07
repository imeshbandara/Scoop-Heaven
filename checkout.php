<?php include('includes/header.php'); ?>

<section class="checkout-form" style="padding: 100px 10%;">
    <h2>Complete Your Order</h2>
    
    <?php 
    
    $selected_flavor = $_GET['flavor'];
    $price = $_GET['price'];
    ?>

    <p>You are ordering: <strong><?php echo $selected_flavor; ?></strong></p>
    <p>Amount to pay: <strong>Rs. <?php echo $price; ?>/=</strong></p>

   <form action="process_order.php" method="POST" style="display: flex; flex-direction: column; gap: 15px; max-width: 400px;">
    
    <input type="hidden" name="flavor_name" value="<?php echo $selected_flavor; ?>">
    <input type="hidden" name="price" value="<?php echo $price; ?>">

    <input type="text" name="cust_name" placeholder="Enter Your Name" required style="padding: 10px;">
    <input type="text" name="cust_phone" placeholder="Phone Number" required style="padding: 10px;">
    <textarea name="cust_address" placeholder="Delivery Address" required style="padding: 10px;"></textarea>
    
    <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
        <label style="font-weight: bold; display: block; margin-bottom: 5px;">How many scoops/packs?</label>
        <input type="number" name="quantity" id="qty" value="1" min="1" onchange="calculateTotal()" 
               style="padding: 10px; width: 60px; border: 1px solid #ccc; border-radius: 5px;">

        <p style="margin-top: 10px; font-size: 1.1rem;">
            Total Amount: <strong>Rs. <span id="display_total"><?php echo $price; ?></span>/=</strong>
        </p>
    </div>

    <button type="submit" name="place_order" class="btn" style="background: #ff4d94; color: white; border: none; padding: 12px; cursor: pointer; border-radius: 5px;">Confirm & Pay (COD)</button>

</form>

<script>
function calculateTotal() {
    let price = <?php echo $price; ?>;
    let qty = document.getElementById('qty').value;
    // Quantity එක 1ට වඩා අඩු නම් ඒක 1ක් බවට පත් කරනවා
    if(qty < 1) {
        document.getElementById('qty').value = 1;
        qty = 1;
    }
    document.getElementById('display_total').innerText = price * qty;
}
</script>
</section>

<?php include('includes/footer.php'); ?>
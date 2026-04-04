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
        
        <button type="submit" name="place_order" class="btn" style="background: #ff4d94; color: white; border: none; cursor: pointer;">Confirm & Pay</button>
    </form>
</section>

<?php include('includes/footer.php'); ?>
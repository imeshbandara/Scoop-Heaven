<?php include('includes/header.php'); ?>

<div class="success-container" style="padding: 150px 10%; text-align: center; min-height: 80vh;">
    <div class="success-card" style="background: var(--card-bg); padding: 40px; border-radius: 30px; box-shadow: var(--box-shadow); max-width: 600px; margin: 0 auto;">
        <i class='bx bxs-check-circle' style="font-size: 80px; color: #4CAF50;"></i>
        <h2 style="margin: 20px 0; color: var(--main-color);">Order Confirmed!</h2>
        
        <p style="font-size: 1.1rem; color: var(--text-color);">
            Thank you, <strong><?php echo htmlspecialchars($_GET['name']); ?></strong>! <br>
            Your <strong><?php echo htmlspecialchars($_GET['flavor']); ?></strong> is being prepared.
        </p>

        <div class="order-details" style="margin: 30px 0; padding: 20px; border: 2px dashed var(--main-color); border-radius: 15px; text-align: left;">
            <p><strong>Order ID:</strong> #SH-<?php echo htmlspecialchars($_GET['id']); ?></p>
            <p><strong>Total Amount:</strong> Rs. <?php echo number_format($_GET['total'], 2); ?></p>
            <p><strong>Payment Method:</strong> Cash on Delivery</p>
        </div>

        <a href="index.php" class="btn">Back to Home</a>
    </div>
</div>

<?php include('includes/footer.php'); ?>
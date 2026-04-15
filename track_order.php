<?php include('includes/header.php'); include('config/db.php'); ?>

<div class="track-container" style="padding: 150px 10%; min-height: 80vh;">
    <div class="track-box" style="max-width: 600px; margin: 0 auto; background: var(--card-bg); padding: 40px; border-radius: 20px; box-shadow: var(--box-shadow);">
        <h2 style="color: var(--main-color); margin-bottom: 20px;">Track Your Scoop</h2>
        <form method="POST">
            <input type="text" name="phone" placeholder="Enter Phone Number used for order" required 
                   style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 15px;">
            <button type="submit" name="track" class="btn" style="width: 100%;">Find My Order</button>
        </form>

        <?php
        if(isset($_POST['track'])) {
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $order_res = mysqli_query($conn, "SELECT * FROM orders WHERE phone = '$phone' ORDER BY order_id DESC LIMIT 1");

            if(mysqli_num_rows($order_res) > 0) {
                $order = mysqli_fetch_assoc($order_res);
                $status = $order['status'] ?? 'Pending';
                $color = ($status == 'Completed') ? '#2ecc71' : (($status == 'Cancelled') ? '#e74c3c' : '#f39c12');
                
                echo "<div style='margin-top: 30px; padding: 20px; background: #fafafa; border-radius: 15px;'>";
                echo "<h3>Order #SH-{$order['order_id']}</h3>";
                echo "<p>Flavor: <strong>{$order['flavor_name']}</strong></p>";
                echo "<p>Status: <span style='color:$color; font-weight:bold;'>$status</span></p>";
                echo "</div>";
            } else {
                echo "<p style='color:red; margin-top: 20px;'>No order found for this phone number.</p>";
            }
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
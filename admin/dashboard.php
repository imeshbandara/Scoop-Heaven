<?php 
include('../config/db.php'); // config folder එක පිටත ඇති නිසා ../ පාවිච්චි කරයි
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="../style.css"> </head>
<body>
    <h2>Admin - Customer Orders</h2>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <tr style="background: #ff4d94; color: white;">
            <th>ID</th>
            <th>Customer Name</th>
            <th>Flavor</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Address</th>
            <th>Status</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['flavor_name']}</td>
                    <td>1</td> <td>Rs. {$row['total_price']}</td>
                    <td>{$row['address']}</td>
                    <td>
                <div style='display:flex; gap:5px;'>
                    <a href='update_status.php?id={$row['order_id']}&status=Completed' 
                       style='background:$btnColor; color:white; padding:5px 10px; border-radius:5px; font-size:12px;'>
                       $status
                    </a>
                    <a href='update_status.php?id={$row['order_id']}&status=Cancelled' 
                       style='background:#eee; color:#333; padding:5px 10px; border-radius:5px; font-size:12px;'>
                       Cancel
                    </a>
                </div>
            </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
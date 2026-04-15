<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include('../config/db.php');
include('admin_nav.php');

// --- 1. THE STATS CALCULATION LOGIC ---
$rev_query = mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders WHERE status = 'Completed'");
$rev_data = mysqli_fetch_assoc($rev_query);
$total_revenue = $rev_data['total'] ?? 0;

$pending_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'Pending'");
$pending_data = mysqli_fetch_assoc($pending_query);
$pending_count = $pending_data['count'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <div style="display: flex; gap: 20px; padding: 20px; background: #f4f4f4; margin-bottom: 20px;">
        <div style="background: white; padding: 20px; border-radius: 15px; flex: 1; box-shadow: var(--box-shadow); border-left: 5px solid #2ecc71;">
            <h3 style="color: #333;">Rs. <?php echo number_format($total_revenue, 2); ?></h3>
            <p style="color: #666; font-size: 14px;">Total Revenue (Completed)</p>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; flex: 1; box-shadow: var(--box-shadow); border-left: 5px solid #f39c12;">
            <h3 style="color: #333;"><?php echo $pending_count; ?></h3>
            <p style="color: #666; font-size: 14px;">Orders to Deliver</p>
        </div>
    </div>

    <h2 style="padding-left: 20px;">Admin - Customer Orders</h2>
    
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse; margin-top: 10px;">
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
        $result = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC");
        while($row = mysqli_fetch_assoc($result)) {
            
            // --- 3. LOGIC TO DEFINE STATUS COLORS ---
            $status = $row['status'] ?? 'Pending';
            $btnColor = ($status == 'Completed') ? '#2ecc71' : (($status == 'Cancelled') ? '#e74c3c' : '#f39c12');

            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['flavor_name']}</td>
                    <td>1</td> 
                    <td>Rs. " . number_format($row['total_price'], 2) . "</td>
                    <td>{$row['address']}</td>
                    <td>
                        <div style='display:flex; gap:5px;'>
                            <a href='update_status.php?id={$row['order_id']}&status=Completed' 
                               style='background:$btnColor; color:white; padding:5px 10px; border-radius:5px; font-size:12px; text-decoration:none;'>
                               $status
                            </a>
                            <a href='update_status.php?id={$row['order_id']}&status=Cancelled' 
                               style='background:#eee; color:#333; padding:5px 10px; border-radius:5px; font-size:12px; text-decoration:none;'>
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
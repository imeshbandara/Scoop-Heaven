<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include('../config/db.php');
?>

<?php
include('../config/db.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Update the status in the database
    // Note: You may need to add a 'status' column to your 'orders' table if it doesn't exist
    $sql = "UPDATE orders SET status = '$status' WHERE order_id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php"); // Redirect back to dashboard
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<?php
include('config/db.php');

if (isset($_POST['place_order'])) {
  
    $customer_name = mysqli_real_escape_string($conn, $_POST['cust_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['cust_phone']);
    $address = mysqli_real_escape_string($conn, $_POST['cust_address']);
    $flavor = mysqli_real_escape_string($conn, $_POST['flavor_name']);
    $total = mysqli_real_escape_string($conn, $_POST['price']);

    $unit_price = $_POST['price'];
    $qty = $_POST['quantity'];
    $final_total = $unit_price * $qty;

    // Database එකට data ඇතුළත් කරන Query එක
   $sql = "INSERT INTO orders (customer_name, phone, address, flavor_name, total_price) 
            VALUES ('$customer_name', '$phone', '$address', '$flavor', '$final_total')";

    if (mysqli_query($conn, $sql)) {
    // Get the ID of the order we just inserted
    $order_id = mysqli_insert_id($conn);
    
    // Redirect to success page with details
    header("Location: success.php?id=$order_id&name=" . urlencode($customer_name) . "&flavor=" . urlencode($flavor) . "&total=$final_total");
    exit();
} else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
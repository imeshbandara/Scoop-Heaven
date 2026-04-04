<?php
include('config/db.php');

if (isset($_POST['place_order'])) {
  
    $customer_name = mysqli_real_escape_string($conn, $_POST['cust_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['cust_phone']);
    $address = mysqli_real_escape_string($conn, $_POST['cust_address']);
    $flavor = mysqli_real_escape_string($conn, $_POST['flavor_name']);
    $total = mysqli_real_escape_string($conn, $_POST['price']);

    // Database එකට data ඇතුළත් කරන Query එක
    $sql = "INSERT INTO orders (customer_name, phone, address, flavor_name, total_price) 
            VALUES ('$customer_name', '$phone', '$address', '$flavor', '$total')";

    if (mysqli_query($conn, $sql)) {
        // Order එක සාර්ථක නම් "Thank You" message එකක් පෙන්නනවා
        echo "<script>
                alert('Order Placed Successfully! We will deliver your ice cream soon.');
                window.location.href='index.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
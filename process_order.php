<?php
session_start();
include('config/db.php');

if (!isset($_POST['place_order'])) {
    exit();
}

$customer_name = mysqli_real_escape_string($conn, $_POST['cust_name'] ?? '');
$phone = mysqli_real_escape_string($conn, $_POST['cust_phone'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['cust_address'] ?? '');

$cart = $_SESSION['cart'] ?? [];
if (!is_array($cart)) {
    $cart = [];
}
$items = array_values($cart);

// Filter invalid items (safety)
$validItems = [];
foreach ($items as $item) {
    $qty = (int)($item['quantity'] ?? 0);
    $price = (float)($item['price'] ?? 0);
    $name = (string)($item['name'] ?? '');
    if ($qty > 0 && $price > 0 && $name !== '') {
        $validItems[] = $item;
    }
}

if (empty($validItems)) {
    // Nothing to place
    header("Location: cart.php");
    exit();
}

$grandTotal = 0.0;
$distinctNames = [];
foreach ($validItems as $item) {
    $qty = (int)($item['quantity'] ?? 0);
    $price = (float)($item['price'] ?? 0);
    $grandTotal += ($qty * $price);
    $distinctNames[(string)($item['name'] ?? '')] = true;
}

$firstName = (string)($validItems[0]['name'] ?? 'Ice Cream');
$flavorHeader = (count($distinctNames) > 1) ? 'Mixed Flavors' : $firstName;

// 1) Insert order header into orders table
$safeFlavorHeader = mysqli_real_escape_string($conn, $flavorHeader);
$sqlHeader = "INSERT INTO orders (customer_name, phone, address, flavor_name, total_price)
              VALUES ('$customer_name', '$phone', '$address', '$safeFlavorHeader', '$grandTotal')";

if (!mysqli_query($conn, $sqlHeader)) {
    echo "Error placing order: " . mysqli_error($conn);
    exit();
}

$order_id = mysqli_insert_id($conn);

// 2) Insert one row per cart item into detailed_orders table
foreach ($validItems as $item) {
    $flavor_name = mysqli_real_escape_string($conn, (string)($item['name'] ?? ''));
    $flavor_id = (int)($item['id'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 0);
    $unit_price = (float)($item['price'] ?? 0);
    $image_path = (string)($item['image'] ?? '');
    if ($image_path !== '' && strpos($image_path, '/') === false) {
        // Defensive: ensure image has path prefix.
        $image_path = 'asset/' . $image_path;
    }
    $image_path_safe = mysqli_real_escape_string($conn, $image_path);

    $line_total = (float)($unit_price * $quantity);

    $sqlDetail = "INSERT INTO detailed_orders
        (order_id, flavor_id, flavor_name, quantity, unit_price, image_path, line_total)
        VALUES
        ('$order_id', '$flavor_id', '$flavor_name', '$quantity', '$unit_price', '$image_path_safe', '$line_total')";

    mysqli_query($conn, $sqlDetail);
}

// Clear cart after successful placement
unset($_SESSION['cart']);

header("Location: success.php?id=$order_id&name=" . urlencode($customer_name) . "&flavor=" . urlencode($flavorHeader) . "&total=$grandTotal");
exit();
?>
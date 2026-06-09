<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}
include('config/db.php');

if (!isset($_POST['place_order'])) {
    exit();
}

$customer_name = trim((string)($_POST['cust_name'] ?? ''));
$phone = trim((string)($_POST['cust_phone'] ?? ''));
$address = trim((string)($_POST['cust_address'] ?? ''));

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

// 1) Insert order header into orders table using Prepared Statement
$stmtHeader = mysqli_prepare($conn, "INSERT INTO orders (customer_name, phone, address, flavor_name, total_price) VALUES (?, ?, ?, ?, ?)");
if ($stmtHeader) {
    mysqli_stmt_bind_param($stmtHeader, "ssssd", $customer_name, $phone, $address, $flavorHeader, $grandTotal);
    if (!mysqli_stmt_execute($stmtHeader)) {
        error_log("Error executing header insert: " . mysqli_stmt_error($stmtHeader));
        die("Error placing order. Please try again.");
    }
    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtHeader);
} else {
    error_log("Error preparing header insert: " . mysqli_error($conn));
    die("Error placing order. Please try again.");
}

// 2) Insert one row per cart item into detailed_orders table using Prepared Statement
$stmtDetail = mysqli_prepare($conn, "INSERT INTO detailed_orders (order_id, flavor_id, flavor_name, quantity, unit_price, image_path, line_total) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmtDetail) {
    foreach ($validItems as $item) {
        $flavor_name = (string)($item['name'] ?? '');
        $flavor_id = (int)($item['id'] ?? 0);
        $quantity = (int)($item['quantity'] ?? 0);
        $unit_price = (float)($item['price'] ?? 0);
        $image_path = (string)($item['image'] ?? '');
        if ($image_path !== '' && strpos($image_path, '/') === false) {
            // Defensive: ensure image has path prefix.
            $image_path = 'asset/' . $image_path;
        }
        $line_total = (float)($unit_price * $quantity);

        mysqli_stmt_bind_param($stmtDetail, "iisisds", $order_id, $flavor_id, $flavor_name, $quantity, $unit_price, $image_path, $line_total);
        if (!mysqli_stmt_execute($stmtDetail)) {
            error_log("Error executing detail insert: " . mysqli_stmt_error($stmtDetail));
        }
    }
    mysqli_stmt_close($stmtDetail);
} else {
    error_log("Error preparing detail insert: " . mysqli_error($conn));
}

// Clear cart after successful placement
unset($_SESSION['cart']);

header("Location: success.php?id=$order_id&name=" . urlencode($customer_name) . "&flavor=" . urlencode($flavorHeader) . "&total=$grandTotal");
exit();
?>
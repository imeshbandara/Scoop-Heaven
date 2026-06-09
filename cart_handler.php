<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}
include('config/db.php');

header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

// Support both JSON body and form-encoded fallback.
if (!is_array($payload)) {
    $payload = $_POST;
}

$action = $payload['action'] ?? '';
$action = (string)$action;

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function cartCount(array $cart): int {
    $count = 0;
    foreach ($cart as $item) {
        $count += (int)($item['quantity'] ?? 0);
    }
    return $count;
}

function cartTotals(array $cart): array {
    $subtotal = 0.0;
    foreach ($cart as $item) {
        $qty = (int)($item['quantity'] ?? 0);
        $price = (float)($item['price'] ?? 0);
        $subtotal += ($price * $qty);
    }
    $grandTotal = $subtotal; // No extra fees right now
    return [
        'subtotal' => $subtotal,
        'grandTotal' => $grandTotal,
    ];
}

$response = [
    'success' => false,
];

try {
    if ($action === 'add') {
        $id = isset($payload['id']) ? (int)$payload['id'] : 0;
        $name = isset($payload['name']) ? (string)$payload['name'] : '';
        $price = isset($payload['price']) ? (float)$payload['price'] : 0;
        $image = isset($payload['image']) ? (string)$payload['image'] : '';

        $qtyToAdd = isset($payload['quantity']) ? (int)$payload['quantity'] : 1;
        if ($qtyToAdd < 1) $qtyToAdd = 1;

        // Image is mandatory per UI, but tolerate missing values by falling back.
        if ($id <= 0 || $name === '' || $price <= 0) {
            throw new Exception('Invalid cart item.');
        }
        if ($image === '') {
            $image = 'asset/main.png';
        }

        $idKey = (string)$id; // store keys as strings in session

        if (!isset($_SESSION['cart'][$idKey])) {
            $_SESSION['cart'][$idKey] = [
                'id' => (int)$id,
                'name' => (string)$name,
                'price' => (float)$price,
                'quantity' => (int)$qtyToAdd,
                'image' => (string)$image,
            ];
        } else {
            $_SESSION['cart'][$idKey]['quantity'] = (int)$_SESSION['cart'][$idKey]['quantity'] + $qtyToAdd;
            // Keep the original stored name/price/image to avoid mismatch.
        }

        $count = cartCount($_SESSION['cart']);
        $totals = cartTotals($_SESSION['cart']);

        $response['success'] = true;
        $response['message'] = $name . ' added to cart!';
        $response['cartCount'] = $count;
        $response['subtotal'] = $totals['subtotal'];
        $response['grandTotal'] = $totals['grandTotal'];
        $response['items'] = array_values($_SESSION['cart']);
    } elseif ($action === 'remove') {
        $id = isset($payload['id']) ? (int)$payload['id'] : 0;
        if ($id <= 0) throw new Exception('Invalid item id.');
        $idKey = (string)$id;
        unset($_SESSION['cart'][$idKey]);

        $count = cartCount($_SESSION['cart']);
        $totals = cartTotals($_SESSION['cart']);

        $response['success'] = true;
        $response['message'] = 'Item removed.';
        $response['cartCount'] = $count;
        $response['subtotal'] = $totals['subtotal'];
        $response['grandTotal'] = $totals['grandTotal'];
        $response['items'] = array_values($_SESSION['cart']);
    } elseif ($action === 'update') {
        $id = isset($payload['id']) ? (int)$payload['id'] : 0;
        $quantity = isset($payload['quantity']) ? (int)$payload['quantity'] : 0;

        if ($id <= 0) throw new Exception('Invalid item id.');
        if ($quantity < 0) $quantity = 0;

        $idKey = (string)$id;
        if (!isset($_SESSION['cart'][$idKey])) {
            // Nothing to update
            throw new Exception('Item not found in cart.');
        }

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$idKey]);
        } else {
            $_SESSION['cart'][$idKey]['quantity'] = $quantity;
        }

        $count = cartCount($_SESSION['cart']);
        $totals = cartTotals($_SESSION['cart']);

        $response['success'] = true;
        $response['message'] = 'Cart updated.';
        $response['cartCount'] = $count;
        $response['subtotal'] = $totals['subtotal'];
        $response['grandTotal'] = $totals['grandTotal'];
        $response['items'] = array_values($_SESSION['cart']);
    } elseif ($action === 'get') {
        $count = cartCount($_SESSION['cart']);
        $totals = cartTotals($_SESSION['cart']);

        $response['success'] = true;
        $response['message'] = 'Cart retrieved.';
        $response['cartCount'] = $count;
        $response['subtotal'] = $totals['subtotal'];
        $response['grandTotal'] = $totals['grandTotal'];
        $response['items'] = array_values($_SESSION['cart']);
    } else {
        throw new Exception('Unsupported action.');
    }
} catch (Throwable $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);

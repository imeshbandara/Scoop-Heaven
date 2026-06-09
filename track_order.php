<?php
include('config/db.php');

$searchedPhone = '';
$order = null;
$orderFound = false;
$error = null;

if (isset($_POST['track'])) {
    $searchedPhone = trim((string)($_POST['phone'] ?? ''));
    $phoneEscaped = mysqli_real_escape_string($conn, $searchedPhone);

    $order_res = mysqli_query(
        $conn,
        "SELECT * FROM orders WHERE phone = '$phoneEscaped' ORDER BY order_id DESC LIMIT 1"
    );

    if ($order_res && mysqli_num_rows($order_res) > 0) {
        $order = mysqli_fetch_assoc($order_res);
        $orderFound = true;
    } else {
        $orderFound = false;
    }
}

function sh_escape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function sh_status_to_step($status)
{
    $s = strtolower(trim((string)$status));

    // common variants / fallbacks
    if ($s === 'delivered' || $s === 'completed') return 3;
    if ($s === 'out for delivery' || $s === 'out_for_delivery' || $s === 'shipping' || $s === 'shipped') return 2;
    if ($s === 'preparing' || $s === 'processing' || $s === 'in progress' || $s === 'in_progress') return 1;
    if ($s === 'placed' || $s === 'order placed' || $s === 'pending') return 0;
    if ($s === 'cancelled' || $s === 'canceled') return -1;

    // unknown status: show "Preparing" progress by default
    return 1;
}

function sh_status_badge($status)
{
    $s = strtolower(trim((string)$status));
    if ($s === 'delivered' || $s === 'completed') return ['Delivered', 'bxs-check-circle', 'success'];
    if ($s === 'cancelled' || $s === 'canceled') return ['Cancelled', 'bxs-x-circle', 'danger'];
    if ($s === 'out for delivery' || $s === 'out_for_delivery' || $s === 'shipping' || $s === 'shipped') return ['Out for Delivery', 'bxs-truck', 'info'];
    if ($s === 'preparing' || $s === 'processing' || $s === 'in progress' || $s === 'in_progress') return ['Preparing', 'bxs-bowl-hot', 'warning'];
    if ($s === 'placed' || $s === 'order placed' || $s === 'pending') return ['Order Placed', 'bxs-receipt', 'neutral'];
    return [trim((string)$status) ?: 'Preparing', 'bxs-bowl-hot', 'warning'];
}

$statusRaw = $orderFound ? ($order['status'] ?? 'Pending') : 'Pending';
$step = sh_status_to_step($statusRaw);
$isCancelled = ($step === -1);

$stages = [
    ['label' => 'Order Placed', 'icon' => 'bxs-receipt'],
    ['label' => 'Preparing', 'icon' => 'bxs-bowl-hot'],
    ['label' => 'Out for Delivery', 'icon' => 'bxs-truck'],
    ['label' => 'Delivered', 'icon' => 'bxs-check-circle'],
];

$progressPercent = 0;
if ($orderFound && !$isCancelled) {
    $safeStep = max(0, min(3, (int)$step));
    $progressPercent = (int)round(($safeStep / 3) * 100);
}

[$statusLabel, $statusIcon, $statusTone] = sh_status_badge($statusRaw);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - Scoop Heaven</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .sh-track {
            --sh-pink: #ff4fa1;
            --sh-pink-soft: #ffe3f0;
            --sh-bg: #fff;
            --sh-ink: #2b2b2b;
            --sh-muted: #6b6b6b;
            --sh-card: #ffffff;
            --sh-border: rgba(43, 43, 43, 0.10);
            --sh-shadow: 0 18px 45px rgba(17, 17, 17, 0.12);
            --sh-radius: 22px;
            padding: 150px 10% 70px;
            min-height: 80vh;
            background:
                radial-gradient(1200px 500px at 50% 0%, rgba(255, 79, 161, 0.12), transparent 55%),
                linear-gradient(180deg, rgba(255, 227, 240, 0.55), transparent 45%);
            color: var(--sh-ink);
        }

        .sh-track__wrap {
            max-width: 880px;
            margin: 0 auto;
        }

        .sh-track__hero {
            text-align: center;
            margin-bottom: 22px;
        }

        .sh-track__title {
            font-size: clamp(26px, 2.2vw, 34px);
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }

        .sh-track__subtitle {
            margin: 0;
            color: var(--sh-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        .sh-search {
            background: var(--sh-card);
            border: 1px solid var(--sh-border);
            box-shadow: var(--sh-shadow);
            border-radius: var(--sh-radius);
            padding: 22px;
            display: grid;
            gap: 14px;
        }

        .sh-field {
            display: grid;
            gap: 8px;
            text-align: left;
        }

        .sh-label {
            font-weight: 600;
            font-size: 13px;
            color: var(--sh-ink);
        }

        .sh-inputWrap {
            position: relative;
        }

        .sh-inputIcon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: rgba(43, 43, 43, 0.55);
            pointer-events: none;
        }

        .sh-input {
            width: 100%;
            border-radius: 16px;
            border: 1.5px solid rgba(43, 43, 43, 0.14);
            padding: 14px 14px 14px 44px;
            font-size: 15px;
            outline: none;
            background: #fff;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .sh-input:focus {
            border-color: rgba(255, 79, 161, 0.70);
            box-shadow: 0 0 0 5px rgba(255, 79, 161, 0.16);
        }

        .sh-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .sh-btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 14px 16px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            background: var(--sh-pink);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
            box-shadow: 0 14px 28px rgba(255, 79, 161, 0.28);
        }

        .sh-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow: 0 18px 34px rgba(255, 79, 161, 0.34);
        }

        .sh-btn:active {
            transform: translateY(0);
        }

        .sh-result {
            margin-top: 20px;
            background: var(--sh-card);
            border: 1px solid var(--sh-border);
            border-radius: var(--sh-radius);
            box-shadow: var(--sh-shadow);
            padding: 22px;
            overflow: hidden;
        }

        .sh-result__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(43, 43, 43, 0.08);
            margin-bottom: 16px;
        }

        .sh-orderId {
            margin: 0;
            font-size: 18px;
            letter-spacing: -0.01em;
        }

        .sh-meta {
            margin: 4px 0 0;
            color: var(--sh-muted);
            font-size: 13px;
        }

        .sh-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 10px 12px;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid rgba(43, 43, 43, 0.10);
            background: #fff;
            white-space: nowrap;
        }

        .sh-badge--success { background: rgba(46, 204, 113, 0.12); border-color: rgba(46, 204, 113, 0.25); }
        .sh-badge--danger { background: rgba(231, 76, 60, 0.12); border-color: rgba(231, 76, 60, 0.25); }
        .sh-badge--warning { background: rgba(243, 156, 18, 0.12); border-color: rgba(243, 156, 18, 0.25); }
        .sh-badge--info { background: rgba(52, 152, 219, 0.12); border-color: rgba(52, 152, 219, 0.25); }
        .sh-badge--neutral { background: rgba(255, 79, 161, 0.10); border-color: rgba(255, 79, 161, 0.25); }

        .sh-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .sh-kv {
            padding: 14px 14px;
            background: rgba(255, 227, 240, 0.35);
            border: 1px solid rgba(255, 79, 161, 0.12);
            border-radius: 18px;
        }

        .sh-k {
            display: block;
            font-size: 12px;
            color: var(--sh-muted);
            margin-bottom: 6px;
            font-weight: 600;
        }

        .sh-v {
            font-weight: 800;
            color: var(--sh-ink);
            font-size: 15px;
            letter-spacing: -0.01em;
        }

        .sh-tracker {
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(43, 43, 43, 0.08);
            padding: 16px 14px 14px;
        }

        .sh-tracker__title {
            margin: 0 0 12px;
            font-size: 14px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sh-steps {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            padding: 14px 8px 0;
            margin: 0;
            list-style: none;
        }

        .sh-steps::before {
            content: "";
            position: absolute;
            left: 18px;
            right: 18px;
            top: 26px;
            height: 8px;
            border-radius: 999px;
            background: rgba(43, 43, 43, 0.08);
        }

        .sh-steps::after {
            content: "";
            position: absolute;
            left: 18px;
            top: 26px;
            height: 8px;
            width: var(--progress, 0%);
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(255, 79, 161, 0.95), rgba(255, 79, 161, 0.55));
            transition: width .35s ease;
        }

        .sh-step {
            display: grid;
            justify-items: center;
            gap: 8px;
            text-align: center;
            min-width: 0;
        }

        .sh-dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff;
            border: 2px solid rgba(43, 43, 43, 0.18);
            z-index: 1;
            color: rgba(43, 43, 43, 0.70);
            transition: transform .2s ease, border-color .2s ease, background .2s ease, color .2s ease;
        }

        .sh-step.is-active .sh-dot,
        .sh-step.is-done .sh-dot {
            border-color: rgba(255, 79, 161, 0.65);
            background: rgba(255, 79, 161, 0.10);
            color: rgba(255, 79, 161, 0.95);
            transform: translateY(-1px);
        }

        .sh-step.is-done .sh-dot {
            background: rgba(255, 79, 161, 0.14);
        }

        .sh-stepLabel {
            font-size: 12px;
            color: rgba(43, 43, 43, 0.78);
            font-weight: 700;
            line-height: 1.3;
        }

        .sh-empty {
            margin-top: 18px;
            background: rgba(255, 227, 240, 0.38);
            border: 1px dashed rgba(255, 79, 161, 0.35);
            border-radius: var(--sh-radius);
            padding: 26px 18px;
            text-align: center;
        }

        .sh-empty__icon {
            font-size: 46px;
            color: rgba(255, 79, 161, 0.95);
            display: inline-block;
            margin-bottom: 10px;
        }

        .sh-empty__title {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.01em;
        }

        .sh-empty__text {
            margin: 0;
            color: var(--sh-muted);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Dark Mode overrides */
        body.dark-mode .sh-track {
            --sh-bg: #1a1a1a;
            --sh-ink: #ffffff;
            --sh-muted: #b0b0b0;
            --sh-card: #2d2d2d;
            --sh-border: rgba(255, 255, 255, 0.12);
            --sh-shadow: 0 18px 45px rgba(0, 0, 0, 0.4);
            background:
                radial-gradient(1200px 500px at 50% 0%, rgba(255, 79, 161, 0.20), transparent 55%),
                linear-gradient(180deg, #1a1a1a, #111111);
        }
        body.dark-mode .sh-input {
            background: #252525;
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.15);
        }
        body.dark-mode .sh-inputIcon {
            color: rgba(255, 255, 255, 0.6);
        }
        body.dark-mode .sh-tracker {
            background: #252525;
            border-color: rgba(255, 255, 255, 0.1);
        }
        body.dark-mode .sh-steps::before {
            background: rgba(255, 255, 255, 0.1);
        }
        body.dark-mode .sh-dot {
            background: #252525;
            border-color: rgba(255, 255, 255, 0.25);
            color: rgba(255, 255, 255, 0.6);
        }
        body.dark-mode .sh-kv {
            background: rgba(255, 79, 161, 0.08);
            border-color: rgba(255, 79, 161, 0.2);
        }
        body.dark-mode .sh-k {
            color: var(--sh-muted);
        }
        body.dark-mode .sh-v {
            color: var(--sh-ink);
        }

        @media (max-width: 850px) {
            .sh-track { padding: 130px 6% 60px; }
            .sh-grid { grid-template-columns: 1fr; }
            .sh-steps { grid-template-columns: 1fr; gap: 14px; padding: 8px 0 0; }
            .sh-steps::before, .sh-steps::after { display: none; }
            .sh-step { grid-template-columns: 34px 1fr; justify-items: start; text-align: left; align-items: center; }
            .sh-stepLabel { font-size: 13px; }
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

<main class="sh-track">
    <div class="sh-track__wrap">
        <div class="sh-track__hero">
            <h1 class="sh-track__title">Track Your Scoop</h1>
            <p class="sh-track__subtitle">
                Enter the phone number you used while ordering, and we’ll show your latest order status.
            </p>
        </div>

        <section class="sh-search" aria-label="Order tracking search">
            <form method="POST" class="sh-search__form" autocomplete="off">
                <div class="sh-field">
                    <label class="sh-label" for="sh-phone">Phone number</label>
                    <div class="sh-inputWrap">
                        <i class='bx bx-phone sh-inputIcon' aria-hidden="true"></i>
                        <input
                            id="sh-phone"
                            class="sh-input"
                            type="tel"
                            name="phone"
                            inputmode="tel"
                            placeholder="Enter your phone number"
                            value="<?php echo sh_escape($searchedPhone); ?>"
                            required
                        />
                    </div>
                </div>

                <div class="sh-actions">
                    <button type="submit" name="track" class="sh-btn">
                        <i class='bx bxs-search' aria-hidden="true"></i>
                        Find My Order
                    </button>
                </div>
            </form>
        </section>

        <?php if ($error): ?>
            <div class="sh-empty" role="alert">
                <i class='bx bxs-error-circle sh-empty__icon' aria-hidden="true"></i>
                <h2 class="sh-empty__title">Something went wrong</h2>
                <p class="sh-empty__text"><?php echo sh_escape($error); ?></p>
            </div>
        <?php elseif (isset($_POST['track']) && !$orderFound): ?>
            <div class="sh-empty" role="status" aria-live="polite">
                <i class='bx bxs-ice-cream sh-empty__icon' aria-hidden="true"></i>
                <h2 class="sh-empty__title">No orders found</h2>
                <p class="sh-empty__text">
                    We couldn’t find an order for that phone number. Please double-check the number and try again.
                </p>
            </div>
        <?php elseif ($orderFound && $order): ?>
            <section class="sh-result" aria-label="Order details">
                <div class="sh-result__top">
                    <div>
                        <h2 class="sh-orderId">Order #SH-<?php echo sh_escape($order['order_id'] ?? ''); ?></h2>
                        <p class="sh-meta">
                            Phone: <?php echo sh_escape($order['phone'] ?? $searchedPhone); ?>
                        </p>
                    </div>

                    <div class="sh-badge sh-badge--<?php echo sh_escape($statusTone); ?>">
                        <i class='bx <?php echo sh_escape($statusIcon); ?>' aria-hidden="true"></i>
                        <span><?php echo sh_escape($statusLabel); ?></span>
                    </div>
                </div>

                <div class="sh-grid">
                    <div class="sh-kv">
                        <span class="sh-k">Flavor</span>
                        <span class="sh-v"><?php echo sh_escape($order['flavor_name'] ?? ''); ?></span>
                    </div>

                    <div class="sh-kv">
                        <span class="sh-k">Current status</span>
                        <span class="sh-v"><?php echo sh_escape($statusLabel); ?></span>
                    </div>
                </div>

                <?php if ($isCancelled): ?>
                    <div class="sh-empty" role="status" aria-live="polite" style="margin-top: 0;">
                        <i class='bx bxs-sad sh-empty__icon' aria-hidden="true"></i>
                        <h3 class="sh-empty__title" style="font-size: 16px;">This order was cancelled</h3>
                        <p class="sh-empty__text">If this looks incorrect, please contact Scoop Heaven support.</p>
                    </div>
                <?php else: ?>
                    <div class="sh-tracker">
                        <h3 class="sh-tracker__title">
                            <i class='bx bxs-map' aria-hidden="true"></i>
                            Status Tracker
                        </h3>

                        <ol class="sh-steps" style="--progress: <?php echo (int)$progressPercent; ?>%;">
                            <?php foreach ($stages as $idx => $stage): ?>
                                <?php
                                $safeStep = max(0, min(3, (int)$step));
                                $cls = ($idx < $safeStep) ? 'is-done' : (($idx === $safeStep) ? 'is-active' : '');
                                ?>
                                <li class="sh-step <?php echo $cls; ?>">
                                    <span class="sh-dot" aria-hidden="true">
                                        <i class='bx <?php echo sh_escape($stage['icon']); ?>'></i>
                                    </span>
                                    <span class="sh-stepLabel"><?php echo sh_escape($stage['label']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>
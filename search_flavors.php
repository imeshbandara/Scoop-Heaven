<?php
include('config/db.php');

$query = "";
if (isset($_POST['query'])) {
    $query = trim((string)$_POST['query']);
}

$searchTerm = "%" . $query . "%";
$stmt = mysqli_prepare($conn, "SELECT * FROM flavors WHERE name LIKE ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $safeName = htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8');
                $safePrice = htmlspecialchars($row['price'] ?? '', ENT_QUOTES, 'UTF-8');
                $rawImg = $row['image_path'] ?? '';
                if ($rawImg !== '' && strpos($rawImg, '/') === false) {
                    $rawImg = 'asset/' . $rawImg;
                }
                if ($rawImg === '') {
                    $rawImg = 'asset/main.png';
                }
                $safeImg = htmlspecialchars($rawImg, ENT_QUOTES, 'UTF-8');
                ?>
                <div class="box">
                    <img src="<?php echo $safeImg; ?>" alt="<?php echo $safeName; ?>" loading="lazy" onerror="this.onerror=null; this.src='asset/main.png';">
                    <h3><?php echo $safeName; ?></h3>
                    <div class="content">
                        <span>Rs. <?php echo $safePrice; ?>/=</span>
                        <a href="checkout.php?flavor=<?php echo urlencode($row['name'] ?? ''); ?>&price=<?php echo urlencode($row['price'] ?? ''); ?>&image=<?php echo urlencode($rawImg); ?>" class="btn">Order Now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No flavors found matching '" . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . "'.</p>";
        }
    }
    mysqli_stmt_close($stmt);
}
?>
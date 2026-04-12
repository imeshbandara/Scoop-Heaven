<?php
include('config/db.php');

$query = "";
if(isset($_POST['query'])) {
    $query = mysqli_real_escape_string($conn, $_POST['query']);
}

$sql = "SELECT * FROM flavors WHERE name LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="box">
            <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>">
            <h3><?php echo $row['name']; ?></h3>
            <div class="content">
                <span>Rs. <?php echo $row['price']; ?>/=</span>
                <a href="checkout.php?flavor=<?php echo urlencode($row['name']); ?>&price=<?php echo $row['price']; ?>&image=<?php echo urlencode($row['image_path']); ?>" class="btn">Order Now</a>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No flavors found matching '$query'.</p>";
}
?>
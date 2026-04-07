<?php include('../config/db.php'); ?>
<h2>Add New Ice Cream Flavor</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Flavor Name" required><br><br>
    <input type="text" name="price" placeholder="Price" required><br><br>
    <input type="file" name="image" required><br><br>
    <button type="submit" name="submit">Add Flavor</button>
</form>

<?php
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Image Uploading Process
    $target_dir = "../"; // Images save වෙන්න ඕන තැන
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO flavors (name, price, image_path) VALUES ('$name', '$price', '$image_name')";
        if(mysqli_query($conn, $sql)) {
            echo "Flavor added successfully!";
        }
    }
}
?>
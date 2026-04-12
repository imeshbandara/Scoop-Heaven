<?php
// Make sure this is at the top to keep the page secure!
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include('../config/db.php');
include('admin_nav.php');

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    // Image Uploading Process
    $target_dir = "../uploads/"; 
    $image_name = time() . "_" . basename($_FILES["image"]["name"]); // time() prevents duplicate name issues
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Simple validation: Check if it's an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save the path "uploads/filename.jpg" so the homepage can find it
            $db_path = "uploads/" . $image_name;
            $sql = "INSERT INTO flavors (name, price, image_path) VALUES ('$name', '$price', '$db_path')";
            
            if(mysqli_query($conn, $sql)) {
                echo "<p style='color:green;'>Flavor added successfully!</p>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

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
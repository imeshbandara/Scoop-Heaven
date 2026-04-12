<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include('../config/db.php');
include('admin_nav.php');

// Handle Deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // 1. Get image path to delete the file from the folder
    $res = mysqli_query($conn, "SELECT image_path FROM flavors WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $file_to_delete = "../" . $row['image_path'];
        if (file_exists($file_to_delete)) {
            unlink($file_to_delete); // This deletes the actual image file
        }
    }

    // 2. Delete from database
    mysqli_query($conn, "DELETE FROM flavors WHERE id = $id");
    header("Location: manage_flavors.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Flavors - Scoop Heaven</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div style="padding: 20px;">
        <h2>Current Menu Items</h2>
        <a href="add_flavor.php" class="btn" style="display:inline-block; margin-bottom:20px;">+ Add New Flavor</a>
        
        <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse; background: var(--card-bg);">
            <tr style="background: var(--main-color); color: white;">
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM flavors");
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td><img src='../{$row['image_path']}' style='width:50px; height:50px; object-fit:cover;'></td>
                        <td>{$row['name']}</td>
                        <td>Rs. {$row['price']}</td>
                        <td>
                            <a href='manage_flavors.php?delete={$row['id']}' 
                               onclick='return confirm(\"Are you sure?\")' 
                               style='color:red;'>Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
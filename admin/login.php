<?php
session_start();
include('../config/db.php');

if(isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

   $result = mysqli_query($conn, "SELECT * FROM scoop_admins WHERE username='$user' AND password='$pass'");
    
    if(mysqli_num_rows($result) == 1) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Scoop Heaven</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .login-box { max-width: 400px; margin: 100px auto; padding: 30px; background: var(--card-bg); border-radius: 20px; box-shadow: var(--box-shadow); text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
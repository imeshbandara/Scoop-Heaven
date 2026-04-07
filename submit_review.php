<?php
include('config/db.php');

if (isset($_POST['submit_rev'])) {
    $name = mysqli_real_escape_string($conn, $_POST['rev_name']);
    $msg = mysqli_real_escape_string($conn, $_POST['rev_msg']);
    $stars = $_POST['rev_stars'];

    $sql = "INSERT INTO reviews (name, message, stars) VALUES ('$name', '$msg', '$stars')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you for your feedback!'); window.location.href='index.php';</script>";
    }
}
?>
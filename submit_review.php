<?php
include('config/db.php');

if (isset($_POST['submit_rev'])) {
    $name = trim((string)($_POST['rev_name'] ?? ''));
    $msg = trim((string)($_POST['rev_msg'] ?? ''));
    $stars = (int)($_POST['rev_stars'] ?? 5);

    $stmt = mysqli_prepare($conn, "INSERT INTO reviews (name, message, stars) VALUES (?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $name, $msg, $stars);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Thank you for your feedback!'); window.location.href='index.php';</script>";
            exit();
        } else {
            error_log("Error executing review insert: " . mysqli_stmt_error($stmt));
            echo "<script>alert('Unable to submit review at this time. Please try again.'); window.location.href='index.php';</script>";
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Error preparing review insert: " . mysqli_error($conn));
        echo "<script>alert('Unable to submit review at this time. Please try again.'); window.location.href='index.php';</script>";
        exit();
    }
}
?>
<?php
// Set secure error reporting rules (hide errors from users, log them internally)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "ice_cream_db"; 

// Enable mysqli exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8"); 
} catch (mysqli_sql_exception $e) {
    // Log detailed connection failure to server error logs
    error_log("Database connection failed: " . $e->getMessage());
    // Terminate script with a clean generic message
    die("Database connection error. Please try again later.");
}
?>
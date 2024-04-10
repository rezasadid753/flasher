<?php
// Database connection settings
define('DB_HOST', 'localhost');
define('DB_USER', 'database_name_goes_here');
define('DB_PASSWORD', 'user_password_goes_here');
define('DB_NAME', 'user_name_goes_here');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die('ارتباط با پایگاه داده ناموفق بود: ' . $conn->connect_error);
}
?>

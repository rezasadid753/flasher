<?php

// Header
$page_title = "ورود"; include 'header.php';

// Database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $access_code = $_POST['access_code'];
    
    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die('<div class="info">ارتباط با پایگاه داده ناموفق بود: ' . $conn->connect_error . '</div>');
    }
    
    // Check if the user's table exists
    $checkTableExistsSQL = "SHOW TABLES LIKE '$access_code'";
    $tableExistsResult = $conn->query($checkTableExistsSQL);
    
    if ($tableExistsResult->num_rows == 1) {
        // Table exists, redirect user to the list page
        header("Location: list.php?access_code=$access_code");
        exit;
    } else {
        // Table does not exist, display error message
        echo '<div class="info">کد دسترسی یافت نشد، اگر قبلا ثبت نام کردید و قادر به ورود نیستید کد دسترسی خود را از طریق راه های ارتباطی مندرج در برگه درباره پروژه ارسال نمائید.</div>';
    }
    
    // Close database connection
    $conn->close();
}

// Footer
echo '</div>';
include 'footer.php';

?>
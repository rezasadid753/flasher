<?php
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
        die('ارتباط با پایگاه داده ناموفق بود: ' . $conn->connect_error);
    }

    // Check if the user's table exists
    $checkTableExistsSQL = "SHOW TABLES LIKE '$access_code'";
    $tableExistsResult = $conn->query($checkTableExistsSQL);

    if ($tableExistsResult->num_rows == 1) {
        // Table exists, redirect user to the list page
        header("Location: list.php?access_code=$access_code");
        exit;
    } else {
        // Table does not exist, store error message
        $accessError = '<div class="info">کد دسترسی وارد شده یافت نشد</div>';
    }

    // Close database connection
    $conn->close();
}

// Header
$page_title = "ورود"; include 'header.php';

// Display error message if it exists
if (!empty($accessError)) {
    echo $accessError;
}

// Footer
echo '</div>';
include 'footer.php';
?>

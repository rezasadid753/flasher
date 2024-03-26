<?php

// Header
$page_title = "ایجاد فلش کارت جدید"; include 'header.php';

// Database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data including the access code
    $access_code = $_POST['access_code'];  // Retrieve the access code from the form
    $content = $_POST['content'];
    $status = $_POST['status'];
    $hint = !empty($_POST['hint']) ? $_POST['hint'] : 'بدون یادداشت'; // Check if hint is provided, if not, use a default value
    
    // Prepare and execute SQL query to insert new flashcard
    $insertFlashcardSQL = "INSERT INTO $access_code (content, hint, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertFlashcardSQL);
    $stmt->bind_param("ssi", $content, $hint, $status);
    
    if ($stmt->execute()) {
        // Redirect user to the list page after successful creation
        header("Location: list.php?access_code=$access_code");
        exit;
    } else {
        echo '<div class="info">خطا در ایجاد فلش کارت: ' . $stmt->error . '</div>';
    }
    $conn->close();
}

// Footer
echo '</div>';
include 'footer.php';

?>
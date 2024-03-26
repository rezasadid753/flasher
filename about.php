<?php

// Header
$page_title = "درباره فلشر"; include 'header.php';

// Database connection
include 'db_connection.php';

// Validate access code
$access_code = $_GET['access_code'];
$table_name = mysqli_real_escape_string($conn, $access_code);
$check_table_query = "SHOW TABLES LIKE '$table_name'";
$result = $conn->query($check_table_query);
if ($result->num_rows != 1) {
    header("Location: login.php");
    exit;
}
?>

<div style="direction: ltr; text-align: left;">
    <div style="font-size: 18px; color: #ff0099;">About Flasher</div>
    This project is a web-based application designed for creating, managing, and reviewing flashcards. It serves as a tool for individuals seeking to enhance their learning experience through the use of flashcards.
    <div style="font-size: 18px; color: #ff0099; margin-top: 10px;">Data Storage</div>
    User data and flashcard information are stored in a MySQL database. Each user is assigned a unique access code upon registration, which serves as the name of their dedicated database table. Flashcards created by users are imported into their respective database tables for organization and accessibility.
    <div style="font-size: 18px; color: #ff0099; margin-top: 10px;">Data Security Disclaimer</div>
    It is important to note that this project does not implement robust security measures to protect user data. Therefore, there is no guarantee of the privacy or stability of the data stored within the system. Users are advised not to input any personal or sensitive information, including access codes or content within flashcards.
</div>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>
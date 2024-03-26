<?php

// Header
$page_title = "ثبت نام"; include 'header.php';

// Database connection
include 'db_connection.php';

// Set UTF-8 Persian Collation for the connection
$conn->set_charset("utf8mb4");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $access_code = $_POST['access_code'];
    
    // Check if access code already exists
    $checkAccessCodeSQL = "SELECT * FROM users WHERE access_code = ?";
    $stmt = $conn->prepare($checkAccessCodeSQL);
    $stmt->bind_param("s", $access_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="info">این کد دسترسی قابل استفاده نیست.</div>';
    } else {
        // Prepare and execute SQL query to create user and flashcards tables
        $createUserTableSQL = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            access_code VARCHAR(255),
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if ($conn->query($createUserTableSQL) === TRUE) {
            // Prepare and execute SQL query to insert user information
            $insertUserSQL = "INSERT INTO users (name, email, access_code) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertUserSQL);
            $stmt->bind_param("sss", $name, $email, $access_code);

            if ($stmt->execute()) {
                // Prepare and execute SQL query to create user's flashcards table
                $createUserFlashcardsTableSQL = "CREATE TABLE IF NOT EXISTS $access_code (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    content VARCHAR(255),
                    hint VARCHAR(255),
                    status INT DEFAULT 1
                ) COLLATE=utf8_persian_ci";

                if ($conn->query($createUserFlashcardsTableSQL) === TRUE) {
                    header("Location: list.php?access_code=$access_code");
                    exit;
                } else {
                    echo '<div class="info">خطایی در ایجاد جدول فلش‌کارت‌های کاربر رخ داد: ' . $conn->error . '</div>';
                }
            } else {
                echo '<div class="info">خطایی در ثبت اطلاعات کاربر رخ داد: ' . $stmt->error . '</div>';
            }
        } else {
            echo '<div class="info">خطایی در ایجاد جدول کاربران رخ داد: ' . $conn->error . '</div>';
        }
    }
    
    // Close database connection
    $conn->close();
}

// Footer
echo '</div>';
include 'footer.php';

?>
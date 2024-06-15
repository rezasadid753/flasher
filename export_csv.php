<?php
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

// Set the table name the same as the access code
$table = $access_code;

// Set the filename
$filename = "export_" . $table . "_flasher_export.csv";

// Query to fetch data from the table, excluding the 'id' column
$query = "SELECT content, hint, status FROM $table";
$result = $conn->query($query);

// Check if query execution was successful
if ($result) {
    // Open the output stream
    $output = fopen('php://output', 'w');

    // Set UTF-8 encoding for the CSV file
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Write column names to the CSV file
    $columns = ['content', 'hint', 'status'];
    fputcsv($output, $columns);

    // Fetch and write data rows to the CSV file
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close the output stream
    fclose($output);

    // Set HTTP headers for CSV download
    header("Content-type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    exit;
} else {
    echo 'خطا در دریافت اطلاعات از پایگاه داده.';
}

// Close database connection
$conn->close();
?>

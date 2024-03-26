<?php

// Database connection
include 'db_connection.php';

// Check if access code is provided
if (!isset($_GET['access_code'])) {
    die('کد دسترسی ارائه نشده است.');
}

$access_code = $_GET['access_code'];
$table = $access_code;

$filename = "export_" . $table . "_flasher_export.csv";

// Query to fetch data from the table
$query = "SELECT * FROM $table";
$result = $conn->query($query);

// Check if query execution was successful
if ($result) {
    // Open the output stream
    $output = fopen('php://output', 'w');

    // Set UTF-8 encoding for the CSV file
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Fetch column names and write them to the CSV file
    $columns = [];
    while ($field = $result->fetch_field()) {
        $columns[] = $field->name;
    }
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

$conn->close();

?>
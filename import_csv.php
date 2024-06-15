<?php
// Include database connection
include 'db_connection.php';

// Function to import data from CSV file to database
function importCSVToDatabase($inputFilename, $conn, $table_name) {
    if (($handle = fopen($inputFilename, "r")) !== FALSE) {
        // Skip the header row
        fgetcsv($handle);

        $length = 1000;
        $delimiter = ",";

        while (($data = fgetcsv($handle, $length, $delimiter)) !== FALSE) {
            // Extract data from CSV row
            $content = $data[0]; // Adjusted index for content
            $hint = $data[1]; // Adjusted index for hint
            $status = $data[2]; // Adjusted index for status

            // Prepare and execute INSERT query
            $query = $conn->prepare("INSERT INTO $table_name (content, hint, status) VALUES (?,?,?)");
            if ($query === false) {
                error_log('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
                return false;
            }
            $query->bind_param('sss', $content, $hint, $status);
            if (!$query->execute()) {
                error_log('Execute failed: (' . $query->errno . ') ' . $query->error);
                return false;
            }
        }

        fclose($handle);
        return true;
    } else {
        error_log('Failed to open file: ' . $inputFilename);
        return false;
    }
}

// Check if form is submitted and file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    // Ensure access_code is provided
    if (isset($_GET['access_code']) && !empty($_GET['access_code'])) {
        $access_code = $_GET['access_code'];
        $table_name = mysqli_real_escape_string($conn, $access_code);

        // File handling
        $inputFilename = $_FILES["csv_file"]["tmp_name"];

        // Check if table exists
        $check_table_query = "SHOW TABLES LIKE '$table_name'";
        $result = $conn->query($check_table_query);
        if ($result->num_rows != 1) {
            $importError = '<div class="info">Table does not exist.</div>';
        } else {
            // Import data from CSV to database
            if (importCSVToDatabase($inputFilename, $conn, $table_name)) {
                header("Location: list.php?access_code=$access_code");
                exit;
            } else {
                $importError = '<div class="info">خطایی حین درون ریزی داده ها رخ داد.</div>';
            }
        }
    } else {
        $importError = '<div class="info">کاربر شناسایی نشد.</div>';
    }
}

// Header
$page_title = "درون ریزی"; include 'header.php';

// Display error message if it exists
if (!empty($importError)) {
    echo $importError;
}

// Footer
echo '</div>';
include 'footer.php';

$conn->close();
?>

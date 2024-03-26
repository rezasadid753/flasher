<?php 

// Header
$page_title = "درون ریزی"; include 'header.php';

// Include database connection
include 'db_connection.php';

// Function to import data from CSV file to database
function importCSVToDatabase($inputFilename, $conn) {
    if (($handle = fopen($inputFilename, "r")) !== FALSE) {
        // Skip the header row
        fgetcsv($handle);
        
        $length = 1000;
        $delimiter = ",";
        
        while (($data = fgetcsv($handle, $length, $delimiter)) !== FALSE) {
            // Extract data from CSV row
            $content = $data[1];
            $hint = $data[2];
            $status = $data[3];
            
            // Prepare and execute INSERT query
            $query = $conn->prepare("INSERT INTO test (content, hint, status) VALUES (?,?,?)");
            $query->bind_param('sss', $content, $hint, $status);
            $query->execute();
        }
        
        fclose($handle);
        return true;
    } else {
        return false;
    }
}

// Check if form is submitted and file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    // File handling
    $inputFilename = $_FILES["csv_file"]["tmp_name"];

    // Import data from CSV to database
    if (importCSVToDatabase($inputFilename, $conn)) {
        header("Location: list.php?access_code=$access_code");
        exit;
    } else {
        echo '<div class="info">خطایی حین درون ریزی داده ها رخ داد.</div>';
    }
}

// Footer
echo '</div>';
include 'footer.php';

?>
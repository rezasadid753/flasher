<?php
// Include database connection
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

// Check if proceed button is clicked
if (isset($_POST['proceed'])) {
    // Perform deletion query
    $query = "DELETE FROM $accessCode"; // Table name is the access code
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful, redirect to list page
        header("Location: list.php?access_code=$accessCode");
        exit;
    } else {
        // Store error message
        $deletionError = '<div class="info">خطا در حذف تمامی فلش کارت ها: ' . mysqli_error($conn) . '</div>';
    }
}

// Header
$page_title = "ایجاد فلش کارت جدید"; include 'header.php';

// Display error message if it exists
if (!empty($deletionError)) {
    echo $deletionError;
}
?>

<div class="question">از حذف تمامی فلش کارت های خود مطمئنید؟</div>
<form action="delete_all_flashcards.php?access_code=<?php echo $accessCode; ?>" method="post" class="column reset" <?php if ($_GET['access_code'] === 'test') echo 'onsubmit="return false;"'; ?>>
    <button type="submit" name="proceed" class="button <?php if ($_GET['access_code'] === 'test') echo "limited"; ?>">ادامه</button>
    <button type="button" id="cancel" class="button secondary">لغو</button>
</form>

<script>
    // Cancel
    document.getElementById('cancel').addEventListener('click', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var accessCode = urlParams.get('access_code');
        window.location.href = 'list.php?access_code=' + accessCode;
    });
</script>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

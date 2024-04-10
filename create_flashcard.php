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

// Header
$page_title = "ایجاد فلش کارت"; 
include 'header.php';
?>

<form action="create_flashcard_process.php" method="POST" <?php if ($access_code === 'test') echo 'onsubmit="return false;"'; ?>>
    <input type="hidden" name="access_code" value="<?php echo $access_code; ?>">
    <label for="content">کلمه</label>
    <input type="text" id="content" name="content" required>
    <label for="hint">یادداشت</label>
    <textarea type="text" id="hint" name="hint"></textarea>
    <label for="status">سطح</label>
    <select id="status" name="status" required>
        <option value="0">آسان</option>
        <option value="1">متوسط</option>
        <option value="2">دشوار</option>
    </select>
    <input type="submit" value="ایجاد فلش کارت" name="create_flashcard" class="button <?php if ($access_code === 'test') echo "limited"; ?>">
</form>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

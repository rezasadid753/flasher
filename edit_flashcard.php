<?php

// Header
$page_title = "ویرایش فلش کارت"; include 'header.php';

// Database connection
include 'db_connection.php';

// Check if flashcard ID and access code are provided in query parameters
if (isset($_GET['flashcard_id']) && isset($_GET['access_code'])) {
    $flashcard_id = $_GET['flashcard_id'];
    $access_code = $_GET['access_code'];

    // Check if the table exists for the given access code
    $table_name = mysqli_real_escape_string($conn, $access_code);
    $check_table_query = "SHOW TABLES LIKE '$table_name'";
    $result = $conn->query($check_table_query);

    if ($result->num_rows == 1) {
        // Retrieve flashcard information from the database based on the ID and access code
        $flashcard_query = "SELECT * FROM $table_name WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($flashcard_query);
        $stmt->bind_param("i", $flashcard_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $flashcard = $result->fetch_assoc();
        } else {
            header("Location: list.php?access_code=$access_code");
            exit;
        }
    } else {
        header("Location: list.php?access_code=$access_code");
        exit;
    }
} else {
    // Redirect to list page if flashcard ID or access code is not provided
    header("Location: list.php?access_code=$access_code");
    exit;
}

// Process form submission to update flashcard information in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $content = $_POST['content'];
    $hint = $_POST['hint'];
    $status = $_POST['status'];

    // Validate form data
    if (!empty($content)) {
        // Update flashcard information in the database
        $update_query = "UPDATE $table_name SET content = ?, hint = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssii", $content, $hint, $status, $flashcard_id);

        if ($stmt->execute()) {
            header("Location: list.php?access_code=$access_code");
            exit;
        } else {
            echo '<div class="info">خطا در ویرایش فلش کارت: ' . $stmt->error . '</div>';
        }
    } else {
        echo '<div class="info">فیلدها نمیتوانند خالی باشند</div>';
    }
}

?>

    <form method="post" <?php if ($_GET['access_code'] === 'test') echo 'onsubmit="return false;"'; ?>>
        <label for="content">کلمه</label>
        <input type="text" id="content" name="content" value="<?php echo $flashcard['content']; ?>" required>
        <label for="hint">یادداشت</label>
        <textarea id="hint" name="hint" required><?php echo $flashcard['hint']; ?></textarea>
        <label for="status">سطح</label>
        <select id="status" name="status" required>
            <option value="0" <?php if ($flashcard['status'] == 0) echo "selected"; ?>>آسان</option>
            <option value="1" <?php if ($flashcard['status'] == 1) echo "selected"; ?>>متوسط</option>
            <option value="2" <?php if ($flashcard['status'] == 2) echo "selected"; ?>>دشوار</option>
        </select>
        <input type="submit" value="ویرایش" class="button <?php if ($_GET['access_code'] === 'test') echo "limited"; ?>">
    </form>

</body>
</html>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>
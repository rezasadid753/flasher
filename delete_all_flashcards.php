<?php
// Include database connection
include 'db_connection.php';

// Check if access code is provided
if (!isset($_GET['access_code'])) {
    echo '<div class="info">کد دسترسی ارائه نشده است.</div>';
    exit;
}

$accessCode = $_GET['access_code'];

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
        // Error occurred
        echo '<div class="info">خطا در حذف تمامی فلش کارت ها: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Header -->
<?php $page_title = "پاکسازی"; include 'header.php'; ?>

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
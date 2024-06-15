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
$page_title = "پخش فلش کارت ها"; include 'header.php';

// Determine filter based on URL parameters
$filter = isset($_GET['noteasy']) ? "status != 0" : (isset($_GET['hard']) ? "status = 2" : (isset($_GET['all']) ? "status >= 0" : ""));

// Query to select flashcards
$flashcards = [];
if (!empty($filter)) {
    $query = "SELECT * FROM $access_code WHERE $filter ORDER BY RAND()";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $flashcards[] = $row;
        }
    } else {
        echo '<div class="info">هیچ فلش کارتی یافت نشد.</div>';
    }
} else {
    // Step 1: Attempt to select cards based on their status
    $status_0_query = "SELECT * FROM $access_code WHERE status = 0 ORDER BY RAND() LIMIT 3";
    $status_1_query = "SELECT * FROM $access_code WHERE status = 1 ORDER BY RAND() LIMIT 4";
    $status_2_query = "SELECT * FROM $access_code WHERE status = 2 ORDER BY RAND() LIMIT 3";
    $status_0_result = $conn->query($status_0_query);
    $status_1_result = $conn->query($status_1_query);
    $status_2_result = $conn->query($status_2_query);
    // Check if all queries returned results
    if ($status_0_result->num_rows == 3 && $status_1_result->num_rows == 4 && $status_2_result->num_rows == 3) {
        // Combine all results
        while ($row = $status_0_result->fetch_assoc()) {
            $flashcards[] = $row;
        }
        while ($row = $status_1_result->fetch_assoc()) {
            $flashcards[] = $row;
        }
        while ($row = $status_2_result->fetch_assoc()) {
            $flashcards[] = $row;
        }
    } else {
        // Step 2: Select random cards if status-based selection fails
        $random_query = "SELECT * FROM $access_code ORDER BY RAND() LIMIT 10";
        $random_result = $conn->query($random_query);
        // Check if enough random cards were selected
        if ($random_result->num_rows >= 10) {
            // Step 4: Return the random flashcards
            while ($row = $random_result->fetch_assoc()) {
                $flashcards[] = $row;
            }
        } else {
            // Step 3: Show error message
            echo '<div class="info">شما حداقل نیاز به 10 فلش کارت دارید تا بتوانید از این بخش استفاده کنید.</div><style>#nextButton{display: none;}</style>';
        }
    }
}

// Close database connection
$conn->close();
?>

<div class="filter-buttons">
    <a href="play.php?access_code=<?php echo $access_code; ?>" class="button <?php echo !isset($_GET['noteasy']) && !isset($_GET['hard']) && !isset($_GET['all']) ? 'active' : ''; ?>">10 کلمه تصادفی</a>
    <a href="play.php?access_code=<?php echo $access_code; ?>&noteasy" class="button <?php echo isset($_GET['noteasy']) ? 'active' : ''; ?>">همه جز آسان</a>
    <a href="play.php?access_code=<?php echo $access_code; ?>&hard" class="button <?php echo isset($_GET['hard']) ? 'active' : ''; ?>">فقط دشوار</a>
    <a href="play.php?access_code=<?php echo $access_code; ?>&all" class="button <?php echo isset($_GET['all']) ? 'active' : ''; ?>">همه</a>
</div>

<?php foreach ($flashcards as $index => $flashcard) : ?>
<div class="pholder <?php echo $index === 0 ? 'first-slide' : ''; ?> <?php echo $index === count($flashcards) - 1 ? 'last-slide' : ''; ?> <?php echo $flashcard['status'] === '2' ? 'hard' : ($flashcard['status'] === '1' ? 'normal' : 'easy'); ?>">
    <div class="pcontent switch"><?php echo $flashcard['content']; ?></div>
    <div class="phint switch"><?php echo $flashcard['hint']; ?></div>
</div>
<?php endforeach; ?>

<button id="prevButton" class="nav-button" style="display: none;"><svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.061 6.439L10.475 1.854C9.80837 1.21717 8.92192 0.861801 7.99999 0.861801C7.07807 0.861801 6.19162 1.21717 5.52499 1.854L0.938993 6.439C0.657598 6.72039 0.499512 7.10205 0.499512 7.5C0.499512 7.89795 0.657598 8.2796 0.938993 8.561C1.22039 8.84239 1.60204 9.00048 1.99999 9.00048C2.39794 9.00048 2.7796 8.84239 3.06099 8.561L7.64699 3.975C7.74076 3.88126 7.86791 3.8286 8.00049 3.8286C8.13307 3.8286 8.26023 3.88126 8.35399 3.975L12.939 8.561C13.2204 8.84239 13.602 9.00048 14 9.00048C14.3979 9.00048 14.7796 8.84239 15.061 8.561C15.3424 8.2796 15.5005 7.89795 15.5005 7.5C15.5005 7.10205 15.3424 6.72039 15.061 6.439Z" fill="#FF0099"/></svg></button>
<button id="nextButton" class="nav-button"><svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.061 6.439L10.475 1.854C9.80837 1.21717 8.92192 0.861801 7.99999 0.861801C7.07807 0.861801 6.19162 1.21717 5.52499 1.854L0.938993 6.439C0.657598 6.72039 0.499512 7.10205 0.499512 7.5C0.499512 7.89795 0.657598 8.2796 0.938993 8.561C1.22039 8.84239 1.60204 9.00048 1.99999 9.00048C2.39794 9.00048 2.7796 8.84239 3.06099 8.561L7.64699 3.975C7.74076 3.88126 7.86791 3.8286 8.00049 3.8286C8.13307 3.8286 8.26023 3.88126 8.35399 3.975L12.939 8.561C13.2204 8.84239 13.602 9.00048 14 9.00048C14.3979 9.00048 14.7796 8.84239 15.061 8.561C15.3424 8.2796 15.5005 7.89795 15.5005 7.5C15.5005 7.10205 15.3424 6.72039 15.061 6.439Z" fill="#FF0099"/></svg></button>
<a href="list.php?access_code=<?php echo $access_code; ?>" id="end" class="nav-button end" style="display: none;"><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.513195 10.487L4.67919 14.653C5.24178 15.2154 6.0047 15.5314 6.8002 15.5314C7.59569 15.5314 8.35861 15.2154 8.92119 14.653L21.7872 1.787C21.9694 1.59839 22.0701 1.34579 22.0679 1.0836C22.0656 0.821399 21.9604 0.570586 21.775 0.385178C21.5896 0.19977 21.3388 0.0946014 21.0766 0.092323C20.8144 0.0900445 20.5618 0.190839 20.3732 0.372997L7.50719 13.239C7.31967 13.4265 7.06536 13.5318 6.8002 13.5318C6.53503 13.5318 6.28072 13.4265 6.09319 13.239L1.92719 9.073C1.73859 8.89084 1.48599 8.79005 1.22379 8.79232C0.961597 8.7946 0.710784 8.89977 0.525376 9.08518C0.339968 9.27059 0.234799 9.5214 0.232521 9.7836C0.230242 10.0458 0.331037 10.2984 0.513195 10.487V10.487Z" fill="white"/></svg></a>

<script>
    var currentIndex = 0;
    var flashcards = document.querySelectorAll('.pholder');
    var totalCards = flashcards.length;

    // Show initial flashcard
    showCard(currentIndex);

    // Event listener for next button
    document.getElementById('nextButton').addEventListener('click', function () {
        if (currentIndex < totalCards - 1) {
            currentIndex++;
            showCard(currentIndex);
            if (currentIndex === totalCards - 1) {
                document.getElementById('nextButton').style.display = 'none';
                document.getElementById('end').style.display = 'flex';
            }
            document.getElementById('prevButton').style.display = 'flex';
        }
    });

    // Event listener for previous button
    document.getElementById('prevButton').addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            showCard(currentIndex);
            if (currentIndex === 0) {
                document.getElementById('prevButton').style.display = 'none';
            }
            document.getElementById('nextButton').style.display = 'flex';
            document.getElementById('end').style.display = 'none';
        }
    });

    // Function to show flashcard at a given index
    function showCard(index) {
        flashcards.forEach(function (card, i) {
            if (i === index) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Toggle flashcards
    var pholders = document.querySelectorAll('.pholder');
    pholders.forEach(function(pholder) {
        pholder.addEventListener('click', function() {
            pholder.classList.toggle('pshowmore');
        });
    });
</script>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

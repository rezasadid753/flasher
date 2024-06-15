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
    <div class='dictionarylistpopup'>
        <a href="https://abadis.ir/entofa/<?php echo $flashcard['content']; ?>" class="abadis" target="_blank">Abadis</a>
        <a href="https://www.merriam-webster.com/dictionary/<?php echo $flashcard['content']; ?>" class="webster" target="_blank">Merriam-Webster</a>
    </div>
    <div class="nav">
        <a href="edit_flashcard.php?flashcard_id=<?php echo $flashcard['id'] ?>&access_code=<?php echo $access_code; ?>" class="edit" target="_blank">
            <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.289399 4.79475C0.104154 4.97994 5.59412e-05 5.23112 0 5.49306V6H0.506941C0.768876 5.99994 1.02006 5.89585 1.20525 5.7106L4.5 2.41585L3.58415 1.5L0.289399 4.79475Z" fill="white"/><path d="M5.78333 0.21667C5.71471 0.147982 5.63323 0.0934915 5.54354 0.0563137C5.45385 0.0191359 5.35772 0 5.26063 0C5.16354 0 5.0674 0.0191359 4.97771 0.0563137C4.88802 0.0934915 4.80654 0.147982 4.73792 0.21667L3.75 1.20488L4.79513 2.25L5.78333 1.26208C5.85202 1.19346 5.90651 1.11198 5.94369 1.02229C5.98086 0.9326 6 0.836463 6 0.739374C6 0.642284 5.98086 0.546147 5.94369 0.456458C5.90651 0.366769 5.85202 0.285287 5.78333 0.21667Z" fill="white"/></svg>
        </a>
        <div class="vline"></div>
        <button class="dictionarypopup">
            <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.04547 4.375C2.04576 4.05661 2.13107 3.74532 2.29081 3.47981C2.45055 3.21429 2.67768 3.00625 2.94399 2.88151C3.2103 2.75677 3.50406 2.72083 3.78878 2.77817C4.0735 2.8355 4.33663 2.98357 4.5455 3.204V0.75C4.5455 0.551088 4.47366 0.360322 4.3458 0.21967C4.21793 0.0790176 4.04451 0 3.86367 0H1.13637C0.8351 0.000396964 0.546268 0.13222 0.333235 0.366555C0.120202 0.600889 0.00036088 0.918601 0 1.25V4.75C0.00036088 5.0814 0.120202 5.39911 0.333235 5.63345C0.546268 5.86778 0.8351 5.9996 1.13637 6H3.52276C3.13096 6 2.75521 5.82879 2.47816 5.52405C2.20112 5.2193 2.04547 4.80598 2.04547 4.375ZM1.13637 1.75C1.13637 1.6837 1.16032 1.62011 1.20294 1.57322C1.24556 1.52634 1.30337 1.5 1.36365 1.5H3.18185C3.24213 1.5 3.29993 1.52634 3.34256 1.57322C3.38518 1.62011 3.40912 1.6837 3.40912 1.75C3.40912 1.8163 3.38518 1.87989 3.34256 1.92678C3.29993 1.97366 3.24213 2 3.18185 2H1.36365C1.30337 2 1.24556 1.97366 1.20294 1.92678C1.16032 1.87989 1.13637 1.8163 1.13637 1.75ZM4.93346 5.92675C4.89084 5.97362 4.83304 5.99995 4.77277 5.99995C4.71251 5.99995 4.65471 5.97362 4.61209 5.92675L4.06504 5.325C3.90303 5.43874 3.71495 5.49944 3.52276 5.5C3.32048 5.5 3.12275 5.43402 2.95456 5.3104C2.78637 5.18679 2.65528 5.01109 2.57788 4.80552C2.50047 4.59995 2.48021 4.37375 2.51968 4.15552C2.55914 3.93729 2.65654 3.73684 2.79958 3.5795C2.94261 3.42217 3.12484 3.31502 3.32324 3.27162C3.52163 3.22821 3.72727 3.25049 3.91415 3.33564C4.10103 3.42078 4.26076 3.56498 4.37314 3.74998C4.48552 3.93499 4.5455 4.1525 4.5455 4.375C4.54499 4.58641 4.48981 4.79329 4.38641 4.9715L4.93346 5.57325C4.97606 5.62013 5 5.68371 5 5.75C5 5.81629 4.97606 5.87987 4.93346 5.92675Z" fill="white"/></svg>
        </button>
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.pholder').forEach(function(pholder) {
            pholder.addEventListener('click', function(event) {
                if (!event.target.closest('.nav') && !event.target.closest('.dictionarylistpopup')) {
                    pholder.classList.toggle('pshowmore');
                }
            });
        });
    });

    // Event listener for dictionary popup toggle
    var dictionaryPopupButtons = document.querySelectorAll('.dictionarypopup');
    dictionaryPopupButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var holder = event.target.closest('.pholder');
            if (holder) {
                var popup = holder.querySelector('.dictionarylistpopup');
                if (popup) {
                    popup.classList.toggle('showdictionarylistpopup');
                }
            }
        });
    });
</script>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

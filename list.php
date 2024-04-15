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

// Handle flashcard deletion if delete_flashcard parameter is present in URL
if (isset($_GET['delete_flashcard'])) {
    $flashcardIdToDelete = $_GET['delete_flashcard'];
    $deleteQuery = "DELETE FROM $access_code WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $flashcardIdToDelete);
    if ($stmt->execute()) {
        // Redirect back to the list page after deletion
        header("Location: list.php?access_code=$access_code");
        exit;
    } else {
        // Store error message
        $deletionError = '<div class="info">خطا در حذف فلش کارت: ' . $conn->error . '</div>';
    }
}

// Header
$page_title = "همه فلش کارت ها"; include 'header.php';

// Display error message if it exists
if (!empty($deletionError)) {
    echo $deletionError;
}
?>

<script>
// Function to remove specified parameters from URL
function removeURLParameters(url, parametersToRemove) {
    // Parse the URL
    var urlParts = url.split('?');
    if (urlParts.length >= 2) {
        var prefix = encodeURIComponent(parametersToRemove) + '=';
        var params = urlParts[1].split(/[&;]/g);

        // Iterate through parameters and remove the specified ones
        for (var i = params.length; i-- > 0;) {
            if (params[i].lastIndexOf(prefix, 0) !== -1) {
                params.splice(i, 1);
            }
        }

        // Reconstruct the URL without the removed parameters
        url = urlParts[0] + (params.length > 0 ? '?' + params.join('&') : '');
    }
    return url;
}

// Function to check if URL contains update_level and level parameters
function shouldRedirect(url) {
    return url.includes('update_level') && url.includes('level');
}

// Function to handle redirection
function redirectIfNecessary() {
    var currentURL = window.location.href;
    if (shouldRedirect(currentURL)) {
        var updatedURL = removeURLParameters(currentURL, 'update_level');
        updatedURL = removeURLParameters(updatedURL, 'level');
        window.location.href = updatedURL; // Redirect to updated URL
    }
}

// Call the redirection function
redirectIfNecessary();
</script>

<div class="column list">
    <a href="create_flashcard.php<?php echo '?access_code=' . $access_code; ?>" class="button secondary">ایجاد</a>
    <button id="alphabeticalSort" class="button secondary">
        <svg width="19" height="12" viewBox="0 0 19 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32769 1.75342H18.1663C18.3874 1.75342 18.5995 1.66106 18.7558 1.49664C18.9122 1.33223 19 1.10923 19 0.876712C19 0.644194 18.9122 0.421199 18.7558 0.256783C18.5995 0.0923678 18.3874 0 18.1663 0H7.32769C7.10657 0 6.89451 0.0923678 6.73815 0.256783C6.5818 0.421199 6.49395 0.644194 6.49395 0.876712C6.49395 1.10923 6.5818 1.33223 6.73815 1.49664C6.89451 1.66106 7.10657 1.75342 7.32769 1.75342Z" fill="#FF0099"/><path d="M16.2361 4.74658H7.3338C7.11106 4.74658 6.89744 4.83894 6.73994 5.00336C6.58244 5.16777 6.49395 5.39077 6.49395 5.62329C6.49395 5.85581 6.58244 6.0788 6.73994 6.24322C6.89744 6.40763 7.11106 6.5 7.3338 6.5H16.2361C16.4589 6.5 16.6725 6.40763 16.83 6.24322C16.9875 6.0788 17.076 5.85581 17.076 5.62329C17.076 5.39077 16.9875 5.16777 16.83 5.00336C16.6725 4.83894 16.4589 4.74658 16.2361 4.74658Z" fill="#FF0099"/><path d="M13.4355 9.64365H7.24847C7.04836 9.64365 6.85645 9.73602 6.71495 9.90044C6.57345 10.0649 6.49395 10.2878 6.49395 10.5204C6.49395 10.7529 6.57345 10.9759 6.71495 11.1403C6.85645 11.3047 7.04836 11.3971 7.24847 11.3971H13.4355C13.6356 11.3971 13.8275 11.3047 13.969 11.1403C14.1105 10.9759 14.19 10.7529 14.19 10.5204C14.19 10.2878 14.1105 10.0649 13.969 9.90044C13.8275 9.73602 13.6356 9.64365 13.4355 9.64365Z" fill="#FF0099"/><path d="M3.52299 0.798488C3.52299 0.357495 3.13071 0 2.64682 0C2.16292 0 1.77065 0.357496 1.77065 0.798489V8.66852C1.77065 8.72298 1.72221 8.76712 1.66245 8.76712H0.240938C0.042754 8.76712 -0.0703734 8.97332 0.0485368 9.11781L2.28519 11.8356C2.46557 12.0548 2.82632 12.0548 3.00669 11.8356L5.24336 9.11781C5.36227 8.97332 5.24914 8.76712 5.05095 8.76712H3.63384C3.57262 8.76712 3.52299 8.72189 3.52299 8.6661V0.798488Z" fill="#FF0099"/></svg>
    </button>
    <button id="randomSort" class="button secondary">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4967 7.00001C12.243 6.9967 12.0283 7.18608 12.0007 7.43752C11.7666 10.1974 9.33244 12.2454 6.56396 12.012C3.79548 11.7786 1.74102 9.35206 1.97519 6.59219C2.20935 3.83233 4.64344 1.78427 7.41192 2.01768C8.61057 2.11874 9.7332 2.64463 10.5763 3.49999H9.01039C8.73339 3.49999 8.50884 3.72384 8.50884 3.99998C8.50884 4.27612 8.73339 4.49997 9.01039 4.49997H11.0884C11.6026 4.49969 12.0195 4.08414 12.0198 3.57147V1.49999C12.0198 1.22385 11.7952 1 11.5182 1C11.2412 1 11.0167 1.22385 11.0167 1.49999V2.539C8.54109 0.333788 4.74099 0.546695 2.52889 3.01455C0.316787 5.4824 0.530358 9.27066 3.00592 11.4759C5.48148 13.6811 9.28156 13.4682 11.4937 11.0003C12.3536 10.041 12.881 8.83125 12.9978 7.54999C13.0236 7.2731 12.8193 7.02783 12.5415 7.00214C12.5267 7.00078 12.5117 7.00005 12.4967 7.00001Z" fill="#FF0099" stroke="#FF0099" stroke-width="0.5"/></svg>
    </button>
    <a href="play.php<?php echo '?access_code=' . $access_code; ?>" class="button play"><svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.492 7.96944L7.95401 0.975435C7.20903 0.42992 6.32755 0.101347 5.40727 0.0261376C4.48699 -0.0490718 3.56385 0.13202 2.74019 0.549339C1.91653 0.966658 1.22451 1.6039 0.740848 2.39044C0.257183 3.17698 0.00076115 4.08209 6.03388e-06 5.00544V19.0004C-0.00143046 19.9247 0.253651 20.8312 0.736856 21.6191C1.22006 22.407 1.91243 23.0453 2.7369 23.463C3.56137 23.8808 4.48559 24.0615 5.40668 23.9851C6.32777 23.9087 7.2096 23.5783 7.95401 23.0304L17.492 16.0364C18.1249 15.572 18.6395 14.965 18.9942 14.2647C19.349 13.5644 19.5338 12.7905 19.5338 12.0054C19.5338 11.2204 19.349 10.4464 18.9942 9.74613C18.6395 9.04583 18.1249 8.43888 17.492 7.97444V7.96944Z" fill="white"/></svg></a>
</div>
<div class="line"></div>
<div class="cards">

<?php
// Check if access code exists in URL
if (isset($_GET['access_code'])) {
    // Handle updating flashcard level
    if (isset($_GET['update_level'])) {
        $flashcardIdToUpdate = $_GET['update_level'];
        $levelToUpdate = $_GET['level'];
        $updateQuery = "UPDATE $access_code SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $levelToUpdate, $flashcardIdToUpdate);
        if ($stmt->execute()) {
            // Redirect back to the list page after updating level
            header("Location: list.php?access_code=$access_code");
            exit;
        } else {
            echo '<div class="info">خطا در بروزرسانی سطح فلش کارت: ' . $conn->error . '</div>';
        }
    }

    // Query to select flashcards
    $flashcard_query = "SELECT * FROM $access_code ORDER BY RAND()";

    // Check if sorting option is selected
    $sort_option = isset($_GET['sort']) ? $_GET['sort'] : '';

    // Apply random order if random sort is selected
    if ($sort_option === 'random') {
        $flashcard_query = "SELECT * FROM $access_code ORDER BY RAND()";
    } elseif ($sort_option === 'alphabetical') {
        $flashcard_query = "SELECT * FROM $access_code ORDER BY content";
    }

    $result = $conn->query($flashcard_query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $content = $row['content'];
            $hint = $row['hint'];
            $level = $row['status'];

            // Add hard class if level is hard
            $hard_class = ($level == 2) ? 'hard' : '';

            // Add normal class if level is normal
            $normal_class = ($level == 1) ? 'normal' : '';

            // Output flashcard HTML
            echo "<div class='holder $hard_class $normal_class'><div class='holderinner'>
                    <div class='word switch'>
                        <div class='inner'>
                            $content
                        </div>
                    </div>
                    <div class='more'>
                        <div class='hint switch'>
                            <div class='inner'>
                                $hint
                            </div>
                        </div>
                        <div class='dictionarylistpopup'>
                            <a href='https://abadis.ir/entofa/$content' class='abadis' target='_blank'>Abadis</a>
                            <a href='https://www.merriam-webster.com/dictionary/$content' class='webster' target='_blank'>Merriam-Webster</a>
                        </div>
                        <div class='nav'>
                        <button class='"; echo ($_GET['access_code'] === 'test') ? "limited" : "delete"; echo "' data-flashcard-id='{$row['id']}'>
                            <svg width='5' height='6' viewBox='0 0 5 6' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M4.75 0.999996H3.97501C3.85539 0.418395 3.34377 0.00075 2.75 0H2.24999C1.65621 0.00075 1.1446 0.418395 1.02499 0.999996H0.249996C0.111926 0.999996 0 1.11192 0 1.24999C0 1.38806 0.111926 1.5 0.249996 1.5H0.499993V4.75C0.500825 5.44001 1.05999 5.99918 1.75 6H3.25C3.94001 5.99918 4.49917 5.44001 4.50001 4.75V1.5H4.75C4.88807 1.5 5 1.38807 5 1.25C5 1.11193 4.88807 0.999996 4.75 0.999996ZM2.25 4.25C2.25 4.38807 2.13808 4.5 2.00001 4.5C1.86192 4.5 1.75 4.38807 1.75 4.25V2.75C1.75 2.61193 1.86192 2.50001 1.99999 2.50001C2.13807 2.50001 2.24999 2.61193 2.24999 2.75L2.25 4.25ZM3.25 4.25C3.25 4.38807 3.13808 4.5 3 4.5C2.86193 4.5 2.75001 4.38807 2.75001 4.25V2.75C2.75001 2.61193 2.86193 2.50001 3 2.50001C3.13808 2.50001 3.25 2.61193 3.25 2.75V4.25ZM1.54275 0.999996C1.64909 0.70057 1.93226 0.500379 2.25 0.499992H2.75001C3.06775 0.500379 3.35092 0.70057 3.45726 0.999996H1.54275Z' fill='white'/></svg>
                        </button>
                        <div class='vline'></div>
                        <a href='edit_flashcard.php?flashcard_id={$row['id']}&access_code=$access_code' class='edit' target='_blank'>
                            <svg width='6' height='6' viewBox='0 0 6 6' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M0.289399 4.79475C0.104154 4.97994 5.59412e-05 5.23112 0 5.49306V6H0.506941C0.768876 5.99994 1.02006 5.89585 1.20525 5.7106L4.5 2.41585L3.58415 1.5L0.289399 4.79475Z' fill='white'/><path d='M5.78333 0.21667C5.71471 0.147982 5.63323 0.0934915 5.54354 0.0563137C5.45385 0.0191359 5.35772 0 5.26063 0C5.16354 0 5.0674 0.0191359 4.97771 0.0563137C4.88802 0.0934915 4.80654 0.147982 4.73792 0.21667L3.75 1.20488L4.79513 2.25L5.78333 1.26208C5.85202 1.19346 5.90651 1.11198 5.94369 1.02229C5.98086 0.9326 6 0.836463 6 0.739374C6 0.642284 5.98086 0.546147 5.94369 0.456458C5.90651 0.366769 5.85202 0.285287 5.78333 0.21667Z' fill='white'/></svg>
                        </a>
                        <div class='vline'></div>
                        <button class='dictionarypopup'>
                            <svg width='5' height='6' viewBox='0 0 5 6' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M2.04547 4.375C2.04576 4.05661 2.13107 3.74532 2.29081 3.47981C2.45055 3.21429 2.67768 3.00625 2.94399 2.88151C3.2103 2.75677 3.50406 2.72083 3.78878 2.77817C4.0735 2.8355 4.33663 2.98357 4.5455 3.204V0.75C4.5455 0.551088 4.47366 0.360322 4.3458 0.21967C4.21793 0.0790176 4.04451 0 3.86367 0H1.13637C0.8351 0.000396964 0.546268 0.13222 0.333235 0.366555C0.120202 0.600889 0.00036088 0.918601 0 1.25V4.75C0.00036088 5.0814 0.120202 5.39911 0.333235 5.63345C0.546268 5.86778 0.8351 5.9996 1.13637 6H3.52276C3.13096 6 2.75521 5.82879 2.47816 5.52405C2.20112 5.2193 2.04547 4.80598 2.04547 4.375ZM1.13637 1.75C1.13637 1.6837 1.16032 1.62011 1.20294 1.57322C1.24556 1.52634 1.30337 1.5 1.36365 1.5H3.18185C3.24213 1.5 3.29993 1.52634 3.34256 1.57322C3.38518 1.62011 3.40912 1.6837 3.40912 1.75C3.40912 1.8163 3.38518 1.87989 3.34256 1.92678C3.29993 1.97366 3.24213 2 3.18185 2H1.36365C1.30337 2 1.24556 1.97366 1.20294 1.92678C1.16032 1.87989 1.13637 1.8163 1.13637 1.75ZM4.93346 5.92675C4.89084 5.97362 4.83304 5.99995 4.77277 5.99995C4.71251 5.99995 4.65471 5.97362 4.61209 5.92675L4.06504 5.325C3.90303 5.43874 3.71495 5.49944 3.52276 5.5C3.32048 5.5 3.12275 5.43402 2.95456 5.3104C2.78637 5.18679 2.65528 5.01109 2.57788 4.80552C2.50047 4.59995 2.48021 4.37375 2.51968 4.15552C2.55914 3.93729 2.65654 3.73684 2.79958 3.5795C2.94261 3.42217 3.12484 3.31502 3.32324 3.27162C3.52163 3.22821 3.72727 3.25049 3.91415 3.33564C4.10103 3.42078 4.26076 3.56498 4.37314 3.74998C4.48552 3.93499 4.5455 4.1525 4.5455 4.375C4.54499 4.58641 4.48981 4.79329 4.38641 4.9715L4.93346 5.57325C4.97606 5.62013 5 5.68371 5 5.75C5 5.81629 4.97606 5.87987 4.93346 5.92675Z' fill='white'/></svg>
                        </button>
                        </div>
                        <select class='flashcard-level "; echo ($_GET['access_code'] === 'test') ? "limited" : "levelchanger"; echo "' data-flashcard-id='{$row['id']}' data-access-code='$access_code'>
                            <option "; echo ($_GET['access_code'] === 'test') ? "style='display: none;' " : ""; echo "value='0'".($level == 0 ? ' selected' : '').">آسان</option>
                            <option "; echo ($_GET['access_code'] === 'test') ? "style='display: none;' " : ""; echo "value='1'".($level == 1 ? ' selected' : '').">متوسط</option>
                            <option "; echo ($_GET['access_code'] === 'test') ? "style='display: none;' " : ""; echo "value='2'".($level == 2 ? ' selected' : '').">دشوار</option>
                        </select>
                    </div>
                </div></div>";
        }
    } else {
        echo '<div class="info">هیج فلش کارتی یافت نشد.</div>';
    }

    // Close database connection
    $conn->close();
} else {
    echo '<div class="info">کد دسترسی شناسایی نشد.</div>';
}
?>

</div>
<div class="line"></div>
<div class="column data">
    <a href="export_csv.php?access_code=<?php echo $access_code; ?>" class="button secondary">برون ریزی</a>
    <form id="csvForm" method="post" enctype="multipart/form-data" class="<?php echo ($_GET['access_code'] === 'test') ? "limited" : "form"; ?>" <?php if ($_GET['access_code'] === 'test') echo 'onsubmit="return false;"'; ?>><input type="file" id="csvFileInput" accept=".csv" style="display: none;"><button type="button" id="importButton" class="button secondary">درون ریزی</button></form>
    <button id="deleteAllButton" class="button secondary">
        <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.50001 1.99999H7.95001C7.71079 0.836789 6.68755 0.0015 5.49999 0H4.49998C3.31243 0.0015 2.28919 0.836789 2.04999 1.99999H0.499993C0.223852 1.99999 0 2.22384 0 2.49998C0 2.77612 0.223852 3 0.499993 3H0.999986V9.49999C1.00165 10.88 2.11997 11.9984 3.5 12H6.5C7.88003 11.9984 8.99835 10.88 9.00001 9.49999V3H9.50001C9.77615 3 10 2.77615 10 2.50001C10 2.22387 9.77615 1.99999 9.50001 1.99999ZM4.50001 8.50001C4.50001 8.77615 4.27615 9 4.00001 9C3.72385 9 3.5 8.77615 3.5 8.50001V5.50001C3.5 5.22387 3.72385 5.00002 3.99999 5.00002C4.27613 5.00002 4.49998 5.22387 4.49998 5.50001L4.50001 8.50001ZM6.5 8.50001C6.5 8.77615 6.27615 9 6.00001 9C5.72387 9 5.50002 8.77615 5.50002 8.50001V5.50001C5.50002 5.22387 5.72387 5.00002 6.00001 5.00002C6.27615 5.00002 6.5 5.22387 6.5 5.50001V8.50001ZM3.0855 1.99999C3.29818 1.40114 3.86452 1.00076 4.50001 0.999984H5.50002C6.1355 1.00076 6.70185 1.40114 6.91452 1.99999H3.0855Z" fill="#FF0099"/></svg>
    </button>
</div>

<script>
    // Event listener for alphabetical sorting button
    document.getElementById('alphabeticalSort').addEventListener('click', function() {
        window.location.href = 'list.php?access_code=<?php echo $access_code; ?>&sort=alphabetical';
    });

    // Event listener for random sorting button
    document.getElementById('randomSort').addEventListener('click', function() {
        window.location.href = 'list.php?access_code=<?php echo $access_code; ?>&sort=random';
    });

    // Event listener for flashcard level change
    document.querySelectorAll('.levelchanger').forEach(function(select) {
        select.addEventListener('change', function() {
            var flashcardId = this.getAttribute('data-flashcard-id');
            var level = this.value;
            window.location.href = 'list.php?access_code=<?php echo $access_code; ?>&update_level=' + flashcardId + '&level=' + level;
        });
    });

    // Event listener for deleting flashcards
    document.querySelectorAll('.delete').forEach(function(button) {
        button.addEventListener('click', function() {
            var flashcardId = this.getAttribute('data-flashcard-id');
            var confirmation = confirm('از حذف این فلش کارت مطمئن هستید؟');
            if (confirmation) {
                window.location.href = 'list.php?access_code=<?php echo $access_code; ?>&delete_flashcard=' + flashcardId;
            }
        });
    });

    // Event listener for dictionary popup toggle
    var dictionaryPopupButtons = document.querySelectorAll('.dictionarypopup');
    dictionaryPopupButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var holder = event.target.closest('.holder');
            if (holder) {
                var popup = holder.querySelector('.dictionarylistpopup');
                if (popup) {
                    popup.classList.toggle('showdictionarylistpopup');
                }
            }
        });
    });

    // Toggle flashcards
    var inners = document.querySelectorAll('.switch');
    inners.forEach(function(inner) {
        inner.addEventListener('click', function() {
            this.closest('.holder').classList.toggle('showmore');
        });
    });

    // Function to handle file selection and submission for input button
    document.getElementById('importButton').addEventListener('click', function() {
        document.getElementById('csvFileInput').click();
    });
    document.getElementById('csvFileInput').addEventListener('change', function() {
        var file = this.files[0];
        var formData = new FormData();
        formData.append('csv_file', file);
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            } else {
                alert('خطایی حین درون ریزی داده ها رخ داد.');
            }
        };
        xhr.open('POST', 'import_csv.php', true);
        xhr.send(formData);
    });

    // Redirect to bulk deletion page
    document.getElementById('deleteAllButton').addEventListener('click', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var accessCode = urlParams.get('access_code');
        window.location.href = 'delete_all_flashcards.php?access_code=' + accessCode;
    });
</script>

<!-- Footer -->
</div>
<div class="info">
    برای مشاهده یادداشت و تنظیمات هر فلش کارت، کافی است روی آن کلیک کنید. با استفاده از دو دکمه مربوط به چینش موجود در بالای صفحه، می توانید فلش کارت ها را به ترتیب حروف الفبا یا به صورت تصادفی مرتب کنید. مرتب سازی تصادفی فلش کارت ها، راهی عالی برای به چالش کشیدن خود و مرور لغات است. با استفاده از گزینه های درون ریزی و برون ریزی می توانید فایل فلش کارت ها را دانلود، ویرایش و یا با دیگران به اشتراک بگذارید.
</div>
<?php include 'footer.php'; ?>

<!-- Header -->
<?php $page_title = "خطا"; include 'header.php'; ?>

<div class="info">
    در اتصال به اینترنت و برقراری ارتباط با سرور خطایی رخ داده است، دقایقی بعد مجدد امتحان کنید و درصورتی که مشکل رقع نشد با اطلاعات تماس درج شده در صفحه درباره پروژه در ارتباط باشید.
</div>
<a id="retryButton" class="button" style="width: 100%;">امتحان مجدد</a>

<script>
    // Refresh button
    document.addEventListener('DOMContentLoaded', function() {
        var retryButton = document.getElementById('retryButton');
        var networkStatus = document.querySelector('.network');
        retryButton.addEventListener('click', function() {
            if (navigator.onLine) {
                // Redirect to login page if online
                window.location.href = 'login.php';
            } else {
                // Show message if offline
                networkStatus.classList.add('showmsg');
            }
        });
    });
</script>

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

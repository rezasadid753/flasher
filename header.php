<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#FF0099">
    <meta name="theme-color" content="#FF0099" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <title>فلشر - <?php echo isset($page_title) ? $page_title : 'Default Title'; ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php
    // Initialize the $logoredirect variable
    $logoredirect = "";
    // Check if access_code parameter exists in the URL
    if(isset($_GET['access_code'])) {
        // If access_code exists, construct the link to list.php with access code
        $accessCode = $_GET['access_code'];
        $logoredirect = "list.php?access_code=$accessCode";
    } else {
        // If access_code doesn't exist, set the link to login.php
        $logoredirect = "login.php";
    }
    ?>
    <header>
        <div class="logo">
            <a href="<?php echo $logoredirect; ?>">
                <img src="favicon.svg" alt="Flasher" />
            </a>
        </div>
        <div class="title">
            <div class="main">
                <a href="<?php echo $logoredirect; ?>">
                    فلشر
                </a>
            </div>
            <div class="sub">
                <a href="<?php echo $logoredirect; ?>">
                    آموزش لغات با فلش کارت
                </a>
            </div>
        </div>
        <div class="menu">
            <button class="openmenu"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="30" height="30"/><path d="M25.0463 13.7134H4.95372C4.42699 13.7134 4 14.289 4 14.999C4 15.7091 4.42699 16.2847 4.95372 16.2847H25.0463C25.573 16.2847 26 15.7091 26 14.999C26 14.289 25.573 13.7134 25.0463 13.7134Z" fill="#FF0099"/><path d="M4.95265 8.57134H18.9362C19.4624 8.57134 19.8889 7.99573 19.8889 7.28567C19.8889 6.57561 19.4624 6 18.9362 6H4.95265C4.42651 6 4 6.57561 4 7.28567C4 7.99573 4.42651 8.57134 4.95265 8.57134Z" fill="#FF0099"/><path d="M14.0913 21.4282H4.90868C4.40683 21.4282 4 22.0039 4 22.7139C4 23.424 4.40683 23.9996 4.90868 23.9996H14.0913C14.5932 23.9996 15 23.424 15 22.7139C15 22.0039 14.5932 21.4282 14.0913 21.4282Z" fill="#FF0099"/></svg></button>
            <button class="closemenu"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="30" height="30" fill="white"/><path d="M6.07162 8.1984L21.8016 23.9281C22.3934 24.52 23.3493 24.5236 23.9366 23.9363C24.5239 23.349 24.5202 22.3932 23.9284 21.8013L8.19845 6.07161C7.6066 5.47977 6.65072 5.47609 6.06341 6.0634C5.4761 6.6507 5.47978 7.60656 6.07162 8.1984Z" fill="#FF0099"/><path d="M6.07162 21.8016L21.8016 6.07189C22.3934 5.48005 23.3493 5.47637 23.9366 6.06368C24.5239 6.65098 24.5202 7.60684 23.9284 8.19868L8.19845 23.9284C7.6066 24.5202 6.65072 24.5239 6.06341 23.9366C5.4761 23.3493 5.47978 22.3934 6.07162 21.8016Z" fill="#FF0099"/></svg></button>
        </div>
    </header>
    <script>
        // Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('service-worker.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }

        // Install Popup
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('popup');
            const closeButton = document.getElementById('closeButton');
            const installButton = document.getElementById('installButton');
            closeButton.addEventListener('click', function() {
                popup.style.bottom = '-100dvh';
                const hideUntil = new Date().getTime() + (1 * 60 * 60 * 1000);
                localStorage.setItem('hidePopupUntil', hideUntil);
            });
            // Save the beforeinstallprompt event for later use
            let deferredPrompt;
            // Event listener for beforeinstallprompt event
            window.addEventListener('beforeinstallprompt', function(event) {
                // Prevent the default prompt
                event.preventDefault();
                // Save the event for later use
                deferredPrompt = event;
            });
            // Event listener for install button click
            installButton.addEventListener('click', function() {
                // Check if the deferredPrompt is available
                if (deferredPrompt) {
                    // Show a custom install prompt
                    popup.style.bottom = '-100dvh';
                    // Prompt the user to install the app
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        } else {
                            console.log('User dismissed the install prompt');
                        }
                        deferredPrompt = null;
                    });
                } else {
                    // If deferredPrompt is not available, show an error message
                    alert('Your browser does not support installing this app.');
                }
            });
            const hideUntil = localStorage.getItem('hidePopupUntil');
            if (!hideUntil || new Date().getTime() > hideUntil) {
                popup.style.bottom = '60px';
            }
        });
    </script>
    <div class="overlay"></div>
    <div class="menupopup">
    <?php if(isset($_GET['access_code'])) { $access_code = $_GET['access_code']; } ?>
        <?php if (!isset($_GET['access_code'])) { ?>
            <a href="login.php" class="link">
                <div class="icon">
                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.00001 6.00023C6.65687 6.00023 8.00002 4.65703 8.00002 3.00012C8.00002 1.3432 6.65687 0 5.00001 0C3.34315 0 2 1.3432 2 3.00012C2 4.65703 3.34315 6.00023 5.00001 6.00023Z" fill="#FF0099"/><path d="M5.00001 6.99981C2.51586 7.00258 0.502766 9.01575 0.5 11.5C0.5 11.7761 0.723852 12 0.999994 12H9.00001C9.27615 12 9.5 11.7761 9.5 11.5C9.49726 9.01575 7.48416 7.00256 5.00001 6.99981Z" fill="#FF0099"/></svg>
                </div>
                <div class="title">
                    ورود
                </div>
                <div class="about">
                    ورود به پنل شخصی با کد دسترسی
                </div>
            </a>
        <?php } ?>
        <?php if (!isset($_GET['access_code'])) { ?>
            <a href="register.php" class="link">
                <div class="icon">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.578797 9.5895C0.208309 9.95987 0.000111882 10.4622 0 10.9861V12H1.01388C1.53775 11.9999 2.04013 11.7917 2.4105 11.4212L9 4.83171L7.16829 3L0.578797 9.5895Z" fill="#FF0099"/><path d="M11.6148 0.385192C11.4928 0.263079 11.348 0.166207 11.1885 0.100113C11.0291 0.0340194 10.8582 0 10.6856 0C10.513 0 10.342 0.0340194 10.1826 0.100113C10.0231 0.166207 9.87829 0.263079 9.75631 0.385192L8 2.142L9.858 4L11.6148 2.24369C11.7369 2.12171 11.8338 1.97685 11.8999 1.8174C11.966 1.65796 12 1.48704 12 1.31444C12 1.14184 11.966 0.970928 11.8999 0.811481C11.8338 0.652034 11.7369 0.507177 11.6148 0.385192Z" fill="#FF0099"/></svg>
                </div>
                <div class="title">
                    ثبت نام
                </div>
                <div class="about">
                    ایجاد حساب کاربری جدید با کد دسترسی جدید
                </div>
            </a>
        <?php } ?>
        <?php if (isset($_GET['access_code'])) { ?>
            <a href="<?php echo 'list.php?access_code=' . $access_code; ?>" class="link">
                <div class="icon">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.81818 0H2.18182C0.976833 0 0 0.976833 0 2.18182V3.81818C0 5.02317 0.976833 6 2.18182 6H3.81818C5.02317 6 6 5.02317 6 3.81818V2.18182C6 0.976833 5.02317 0 3.81818 0Z" fill="#FF0099"/><path d="M3.81818 7H2.18182C0.976833 7 0 7.81403 0 8.81818V10.1818C0 11.186 0.976833 12 2.18182 12H3.81818C5.02317 12 6 11.186 6 10.1818V8.81818C6 7.81403 5.02317 7 3.81818 7Z" fill="#FF0099"/><path d="M11.1463 9.56318L9.99994 10.7081V1.29261L11.1463 2.43755C11.1928 2.48397 11.2479 2.52079 11.3086 2.5459C11.3693 2.57101 11.4343 2.58392 11.5 2.5839C11.5656 2.58387 11.6306 2.57092 11.6913 2.54576C11.752 2.52061 11.8071 2.48376 11.8535 2.4373C11.8999 2.39085 11.9367 2.33571 11.9618 2.27503C11.9869 2.21435 11.9998 2.14932 11.9998 2.08364C11.9998 2.01797 11.9868 1.95295 11.9617 1.89229C11.9365 1.83162 11.8997 1.77651 11.8532 1.73009L10.5599 0.438657C10.2787 0.157771 9.89746 0 9.5 0C9.10254 0 8.72134 0.157771 8.44012 0.438657L7.14676 1.73009C7.10031 1.77651 7.06346 1.83162 7.03831 1.89229C7.01316 1.95295 7.0002 2.01797 7.00018 2.08364C7.00015 2.14932 7.01306 2.21435 7.03817 2.27503C7.06328 2.33571 7.10009 2.39085 7.14651 2.4373C7.19293 2.48376 7.24804 2.52061 7.3087 2.54576C7.36936 2.57092 7.43438 2.58387 7.50005 2.5839C7.56571 2.58392 7.63074 2.57101 7.69142 2.5459C7.7521 2.52079 7.80723 2.48397 7.85368 2.43755L9.00006 1.29261V10.7081L7.85368 9.56318C7.8072 9.51676 7.75203 9.47995 7.69132 9.45486C7.63062 9.42976 7.56556 9.41687 7.49987 9.41691C7.43418 9.41696 7.36914 9.42994 7.30847 9.45513C7.2478 9.48031 7.19268 9.5172 7.14626 9.56368C7.09984 9.61017 7.06304 9.66534 7.03794 9.72605C7.01285 9.78676 6.99995 9.85182 7 9.91752C7.00005 9.98321 7.01303 10.0483 7.03821 10.1089C7.06339 10.1696 7.10028 10.2247 7.14676 10.2711L8.44012 11.5626C8.72172 11.8427 9.10278 12 9.5 12C9.89722 12 10.2783 11.8427 10.5599 11.5626L11.8532 10.2711C11.9471 10.1774 11.9999 10.0502 12 9.91752C12.0001 9.78484 11.9475 9.65756 11.8537 9.56368C11.76 9.4698 11.6328 9.41701 11.5001 9.41691C11.3675 9.41682 11.2402 9.46943 11.1463 9.56318Z" fill="#FF0099"/></svg>
                </div>
                <div class="title">
                    همه فلش کارت ها
                </div>
                <div class="about">
                    مشاهده و مدیریت همه فلش کارت های ایجاد شده
                </div>
            </a>
        <?php } ?>
        <?php if (isset($_GET['access_code'])) { ?>
            <a href="<?php echo 'play.php?access_code=' . $access_code; ?>" class="link">
                <div class="icon">
                    <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.492 7.96944L7.95401 0.975435C7.20903 0.42992 6.32755 0.101347 5.40727 0.0261376C4.48699 -0.0490718 3.56385 0.13202 2.74019 0.549339C1.91653 0.966658 1.22451 1.6039 0.740848 2.39044C0.257183 3.17698 0.00076115 4.08209 6.03388e-06 5.00544V19.0004C-0.00143046 19.9247 0.253651 20.8312 0.736856 21.6191C1.22006 22.407 1.91243 23.0453 2.7369 23.463C3.56137 23.8808 4.48559 24.0615 5.40668 23.9851C6.32777 23.9087 7.2096 23.5783 7.95401 23.0304L17.492 16.0364C18.1249 15.572 18.6395 14.965 18.9942 14.2647C19.349 13.5644 19.5338 12.7905 19.5338 12.0054C19.5338 11.2204 19.349 10.4464 18.9942 9.74613C18.6395 9.04583 18.1249 8.43888 17.492 7.97444V7.96944Z" fill="#FF0099"/></svg>
                </div>
                <div class="title">
                    پخش فلش کارت ها
                </div>
                <div class="about">
                    نمایش تمامی فلش کارت ها بصورت تکی برای مرور
                </div>
            </a>
        <?php } ?>
        <?php if (isset($_GET['access_code'])) { ?>
            <a href="<?php echo 'create_flashcard.php?access_code=' . $access_code; ?>" class="link">
                <div class="icon">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 5H7V1C7 0.734784 6.89464 0.48043 6.70711 0.292893C6.51957 0.105357 6.26522 0 6 0C5.73478 0 5.48043 0.105357 5.29289 0.292893C5.10536 0.48043 5 0.734784 5 1V5H1C0.734784 5 0.48043 5.10536 0.292893 5.29289C0.105357 5.48043 0 5.73478 0 6C0 6.26522 0.105357 6.51957 0.292893 6.70711C0.48043 6.89464 0.734784 7 1 7H5V11C5 11.2652 5.10536 11.5196 5.29289 11.7071C5.48043 11.8946 5.73478 12 6 12C6.26522 12 6.51957 11.8946 6.70711 11.7071C6.89464 11.5196 7 11.2652 7 11V7H11C11.2652 7 11.5196 6.89464 11.7071 6.70711C11.8946 6.51957 12 6.26522 12 6C12 5.73478 11.8946 5.48043 11.7071 5.29289C11.5196 5.10536 11.2652 5 11 5Z" fill="#FF0099"/></svg>
                </div>
                <div class="title">
                    ایجاد فلش کارت
                </div>
                <div class="about">
                    افزودن فلش کارت جدید به پایگاه داده
                </div>
            </a>
        <?php } ?>
        <?php if (isset($_GET['access_code'])) { ?>
            <a href="login.php" class="link">
                <div class="icon">
                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7H14M14 7L11.4118 4M14 7L11.4118 10" stroke="#FF0099" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.50001 12H3.49999C2.67157 12 1.99999 11.3284 1.99999 10.5V3.50001C1.99999 2.67159 2.67157 2.00001 3.49999 2.00001H5.50001C5.77615 2.00001 6 1.77616 6 1.50002C6 1.22388 5.77617 1 5.50001 1H3.49999C2.11999 1.00166 1.00166 2.11998 1 3.50001V10.5C1.00166 11.88 2.11999 12.9984 3.50001 13H5.50003C5.77617 13 6.00002 12.7761 6.00002 12.5C6.00002 12.2239 5.77617 12 5.50001 12Z" fill="#FF0099" stroke="#FF0099"/></svg>
                </div>
                <div class="title">
                    خروج از حساب
                </div>
                <div class="about">
                    بازگشت به صفحه ورود برای وارد شدن با کد دسترسی دیگر
                </div>
            </a>
        <?php } ?>
        <a href="about.php" class="link">
            <div class="icon">
                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 3.31308C0 2.8111 0.162667 2.30383 0.488 1.79128C0.813333 1.27345 1.288 0.845443 1.912 0.507266C2.536 0.169089 3.264 0 4.096 0C4.86933 0 5.552 0.142668 6.144 0.428005C6.736 0.708058 7.192 1.09115 7.512 1.57728C7.83733 2.06341 8 2.59181 8 3.16248C8 3.61162 7.90667 4.00528 7.72 4.34346C7.53867 4.68164 7.32 4.9749 7.064 5.22325C6.81333 5.46631 6.36 5.87847 5.704 6.45971C5.52267 6.62351 5.376 6.76882 5.264 6.89564C5.15733 7.01717 5.07733 7.13078 5.024 7.23646C4.97067 7.33686 4.928 7.43989 4.896 7.54557C4.86933 7.64597 4.82667 7.82563 4.768 8.08454C4.66667 8.63408 4.34933 8.90885 3.816 8.90885C3.53867 8.90885 3.304 8.81902 3.112 8.63937C2.92533 8.45971 2.832 8.19287 2.832 7.83884C2.832 7.39498 2.90133 7.01189 3.04 6.68956C3.17867 6.36196 3.36267 6.07662 3.592 5.83355C3.82133 5.5852 4.13067 5.29194 4.52 4.95376C4.86133 4.65786 5.10667 4.43593 5.256 4.28798C5.41067 4.13474 5.53867 3.96565 5.64 3.78071C5.74667 3.59577 5.8 3.39498 5.8 3.17834C5.8 2.75561 5.64 2.39894 5.32 2.10832C5.00533 1.8177 4.59733 1.67239 4.096 1.67239C3.50933 1.67239 3.07733 1.82034 2.8 2.11625C2.52267 2.40687 2.288 2.83752 2.096 3.40819C1.91467 4.00528 1.57067 4.30383 1.064 4.30383C0.765333 4.30383 0.512 4.20079 0.304 3.99472C0.101333 3.78336 0 3.55614 0 3.31308ZM3.904 12C3.57867 12 3.29333 11.897 3.048 11.6909C2.808 11.4795 2.688 11.1863 2.688 10.8111C2.688 10.4782 2.80533 10.1982 3.04 9.97094C3.27467 9.74373 3.56267 9.63012 3.904 9.63012C4.24 9.63012 4.52267 9.74373 4.752 9.97094C4.98133 10.1982 5.096 10.4782 5.096 10.8111C5.096 11.181 4.976 11.4716 4.736 11.683C4.496 11.8943 4.21867 12 3.904 12Z" fill="#FF0099"/></svg>
            </div>
            <div class="title">
                درباره پروژه
            </div>
            <div class="about">
                جزئیات و قوانین استفاده از این وبسایت
            </div>
        </a>
    </div>
    <div class="notif fncmsgsuccess">
        عبارت با موفقیت کپی شد
    </div>
    <div class="notif fncmsgfail">
        خطایی در کپی عبارت رخ داد
    </div>
    <div class="notif limitmsg">
        این گزینه برای کاربر تست غیرفعال شده است
    </div>
    <div class="notif network">
        ارتباط با سرور ناموفق بود
    </div>
    <div id="popup" class="pwa">
        <div class="text">نصب وب اپلیکیشن</div>
        <a href="#" class="button installApp" download>دانلود اپلیکیشن</a>
        <button id="installButton" class="button installButton"><span class="desktop">نصب</span><span class="mobile">وب اپ</span></button>
        <button id="closeButton" class="button secondary closeButton"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 0.99997C12.8125 0.812499 12.5582 0.707184 12.293 0.707184C12.0278 0.707184 11.7735 0.812499 11.586 0.99997L7 5.58597L2.414 0.99997C2.22647 0.812499 1.97217 0.707184 1.707 0.707184C1.44184 0.707184 1.18753 0.812499 1 0.99997C0.81253 1.1875 0.707214 1.44181 0.707214 1.70697C0.707214 1.97213 0.81253 2.22644 1 2.41397L5.586 6.99997L1 11.586C0.81253 11.7735 0.707214 12.0278 0.707214 12.293C0.707214 12.5581 0.81253 12.8124 1 13C1.18753 13.1874 1.44184 13.2928 1.707 13.2928C1.97217 13.2928 2.22647 13.1874 2.414 13L7 8.41397L11.586 13C11.7735 13.1874 12.0278 13.2928 12.293 13.2928C12.5582 13.2928 12.8125 13.1874 13 13C13.1875 12.8124 13.2928 12.5581 13.2928 12.293C13.2928 12.0278 13.1875 11.7735 13 11.586L8.414 6.99997L13 2.41397C13.1875 2.22644 13.2928 1.97213 13.2928 1.70697C13.2928 1.44181 13.1875 1.1875 13 0.99997V0.99997Z" fill="#FF0099"/></svg></button>
    </div>
    <div class="container">
        <div id="top"></div>
        <h1 class="pagetitle">
            <?php echo isset($page_title) ? $page_title : 'فلشر'; ?>
            <div class="line"></div>
        </h1>
        <div class="content">
            <div class="scrollbar top">
                <a href="#top">
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.061 6.439L10.475 1.854C9.80837 1.21717 8.92192 0.861801 7.99999 0.861801C7.07807 0.861801 6.19162 1.21717 5.52499 1.854L0.938993 6.439C0.657598 6.72039 0.499512 7.10205 0.499512 7.5C0.499512 7.89795 0.657598 8.2796 0.938993 8.561C1.22039 8.84239 1.60204 9.00048 1.99999 9.00048C2.39794 9.00048 2.7796 8.84239 3.06099 8.561L7.64699 3.975C7.74076 3.88126 7.86791 3.8286 8.00049 3.8286C8.13307 3.8286 8.26023 3.88126 8.35399 3.975L12.939 8.561C13.2204 8.84239 13.602 9.00048 14 9.00048C14.3979 9.00048 14.7796 8.84239 15.061 8.561C15.3424 8.2796 15.5005 7.89795 15.5005 7.5C15.5005 7.10205 15.3424 6.72039 15.061 6.439Z" fill="#FF0099"/></svg>
                </a>
            </div>
            <div class="scrollarea">
                <div class="scrollbar center">
                    <a href="#top">
                        <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.061 6.439L10.475 1.854C9.80837 1.21717 8.92192 0.861801 7.99999 0.861801C7.07807 0.861801 6.19162 1.21717 5.52499 1.854L0.938993 6.439C0.657598 6.72039 0.499512 7.10205 0.499512 7.5C0.499512 7.89795 0.657598 8.2796 0.938993 8.561C1.22039 8.84239 1.60204 9.00048 1.99999 9.00048C2.39794 9.00048 2.7796 8.84239 3.06099 8.561L7.64699 3.975C7.74076 3.88126 7.86791 3.8286 8.00049 3.8286C8.13307 3.8286 8.26023 3.88126 8.35399 3.975L12.939 8.561C13.2204 8.84239 13.602 9.00048 14 9.00048C14.3979 9.00048 14.7796 8.84239 15.061 8.561C15.3424 8.2796 15.5005 7.89795 15.5005 7.5C15.5005 7.10205 15.3424 6.72039 15.061 6.439Z" fill="#FF0099"/></svg>
                    </a>
                    <a href="#bottom">
                        <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.0612 0.853986C14.9219 0.714597 14.7565 0.604021 14.5744 0.528579C14.3924 0.453137 14.1973 0.414307 14.0002 0.414307C13.8031 0.414307 13.608 0.453137 13.4259 0.528579C13.2439 0.604021 13.0785 0.714597 12.9392 0.853986L8.35319 5.43899C8.25942 5.53272 8.13227 5.58538 7.99969 5.58538C7.86711 5.58538 7.73995 5.53272 7.64619 5.43899L3.06119 0.853986C2.77993 0.572592 2.3984 0.414453 2.00054 0.414359C1.60268 0.414265 1.22108 0.572224 0.939688 0.853486C0.658293 1.13475 0.500155 1.51627 0.500061 1.91413C0.499967 2.31199 0.657926 2.69359 0.939188 2.97499L5.52519 7.56099C5.8502 7.88603 6.23605 8.14387 6.66071 8.31978C7.08538 8.4957 7.54053 8.58624 8.00019 8.58624C8.45984 8.58624 8.915 8.4957 9.33966 8.31978C9.76432 8.14387 10.1502 7.88603 10.4752 7.56099L15.0612 2.97499C15.3424 2.6937 15.5004 2.31223 15.5004 1.91449C15.5004 1.51674 15.3424 1.13528 15.0612 0.853986Z" fill="#FF0099"/></svg>
                    </a>
                </div>
            </div>
            <div class="scrollbar bottom">
                <a href="#bottom">
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.0612 0.853986C14.9219 0.714597 14.7565 0.604021 14.5744 0.528579C14.3924 0.453137 14.1973 0.414307 14.0002 0.414307C13.8031 0.414307 13.608 0.453137 13.4259 0.528579C13.2439 0.604021 13.0785 0.714597 12.9392 0.853986L8.35319 5.43899C8.25942 5.53272 8.13227 5.58538 7.99969 5.58538C7.86711 5.58538 7.73995 5.53272 7.64619 5.43899L3.06119 0.853986C2.77993 0.572592 2.3984 0.414453 2.00054 0.414359C1.60268 0.414265 1.22108 0.572224 0.939688 0.853486C0.658293 1.13475 0.500155 1.51627 0.500061 1.91413C0.499967 2.31199 0.657926 2.69359 0.939188 2.97499L5.52519 7.56099C5.8502 7.88603 6.23605 8.14387 6.66071 8.31978C7.08538 8.4957 7.54053 8.58624 8.00019 8.58624C8.45984 8.58624 8.915 8.4957 9.33966 8.31978C9.76432 8.14387 10.1502 7.88603 10.4752 7.56099L15.0612 2.97499C15.3424 2.6937 15.5004 2.31223 15.5004 1.91449C15.5004 1.51674 15.3424 1.13528 15.0612 0.853986Z" fill="#FF0099"/></svg>
                </a>
            </div>
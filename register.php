<!-- Header -->
<?php $page_title = "ثبت نام"; include 'header.php'; ?>

<form action="register_process.php" method="post">
    <label for="name">نام</label>
    <input type="text" id="name" name="name" required>
    <label for="phone">ایمیل</label>
    <input type="email" id="email" name="email" required>
    <label for="access_code">کد دسترسی</label>
    <input type="text" id="access_code" name="access_code" pattern="[a-z0-9]{6,}" title="کد دسترسی بایستی حداقل 6 کاراکتر و تنها متشکل از حروف انگلیسی کوچک و اعداد باشد و میان کاراکتر ها فاصله نباشد" required>
    <input type="submit" value="ثبت نام" class="button">
</form>
<div class="info">
    کد دسترسی بایستی حداقل 6 کاراکتر و تنها متشکل از حروف انگلیسی کوچک و اعداد باشد و میان کاراکتر ها فاصله نباشد
</div>
<div class="line"></div>
<div class="column">
    <div class="question">
        قبلا ثبت نام کردید؟
    </div>
    <a href="login.php" class="button secondary">ورود</a>
</div>

<!-- Footer -->
</div>
<div class="info">
    اطلاعات شما خصوصی نیست، تمام داده‌هایی که در این سایت وارد می‌کنید از جمله کد دسترسی شما به طور عمومی قابل مشاهده خواهد بود. به هیچ عنوان از اطلاعات محرمانه خود، چه به عنوان کد دسترسی و چه به عنوان محتوای فلش کارت، استفاده نکنید. این سایت یک پروژه آزمایشی است لذا هیچ مسئولیتی در قبال از دست رفتن یا سوء استفاده از داده‌های شما، اعم از کد دسترسی یا محتوای فلش کارت، پذیرفته نمی‌شود. با ثبت نام در این سایت، شما به طور ضمنی به موارد فوق اذعان می‌کنید. در صورت مشاهده هر گونه مشکل یا سوء استفاده، لطفا از طریق راه های ارتباطی درج شده در صفحه درباره پروژه گزارش دهید.
</div>
<?php include 'footer.php'; ?>
<!-- Header -->
<?php $page_title = "ورود"; include 'header.php'; ?>

<form action="login_process.php" method="POST">
    <label for="access_code">کد دسترسی</label>
    <input type="text" id="access_code" name="access_code" required>
    <input type="submit" value="ورود" class="button">
</form>
<div class="line"></div>
<div class="column">
    <div class="question">
        تا کنون ثبت نام نکردید؟
    </div>
    <a href="register.php" class="button secondary">ثبت نام</a>
</div>

<!-- Footer -->
</div>
<div class="info">
    با وارد کردن کدهای دسترسی پایین میتوانید به فلش کارت های عمومی را مشاهده و استفاده کنید: 
    برای کل اصطلاحات کتاب Essential Idioms in English از کد دسترسی <code>idioms</code> استفاده کنید. 
    برای اصطلاحات سطح Advance کتاب Essential Idioms in English از کد دسترسی <code>idiomsadv</code> استفاده کنید. 
    با زدن بر روی کدها میتوانید آنها را کپی کنید
</div>
<div class="info">
    درصورت تمایل به ویرایش هر کدام از مجموعه فلش کارت های فوق، ابتدا برون ریزی کنید و سپس از بخش ثبت نام حساب جدیدی ایجاد کنید (برای کاربران محدودیتی در ایجاد مجموعه فلش کارت جدید وجود ندارد و هر کاربر به تعداد دلخواه میتواند کد دسترسی جدید تعریف کند) و سپس بر روی درون ریزی کلیک کنید و فایل دانلود شده را انتخاب کنید تا در حساب شما فلش کارت ها در مجموعه شما نیز ایجاد شوند و بتوانید آنها را ویرایش کنید.
</div>
<?php include 'footer.php'; ?>

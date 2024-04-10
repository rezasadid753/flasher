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
    برای تست سامانه میتوانید از حساب کاربری تست با کد دسترسی <code>test</code> استفاده کنید، توجه داشته باشید که این حساب کاربری در ایجاد و ویرایش فلش کارت های تعریف شده بصورت پیشفرض دارای محدودیت هایی میباشد.
</div>
<?php include 'footer.php'; ?>

<?php
// Header
$page_title = "درباره فلشر"; include 'header.php';
?>

<div style="font-size: 20px;color: #ff0099;text-align: right;width: 100%;border-bottom: 2px solid #ff0099;padding-bottom: 10px;">درباره فلشر</div>
این پروژه یک اپلیکیشن تحت وب است که برای ساخت، مدیریت و مرور کارت‌های آموزشی (flashcards) طراحی شده است. فلشر به عنوان ابزاری برای افرادی عمل می‌کند که به دنبال بهبود تجربه یادگیری خود از طریق استفاده از کارت‌های آموزشی هستند.
<div style="font-size: 19px;color: #ff0099;margin-top: 10px;text-align: right;width: 100%;border-bottom: 2px solid #ff0099;padding-bottom: 10px;">ذخیره‌سازی داده</div>
داده‌های کاربر و اطلاعات کارت‌های آموزشی در یک پایگاه داده MySQL ذخیره می‌شوند. به هر کاربر پس از ثبت‌نام، یک کد دسترسی منحصر‌به‌فرد اختصاص داده می‌شود که به عنوان نام جدول اختصاصی پایگاه داده او عمل می‌کند. کارت‌های آموزشی ایجاد شده توسط کاربران برای سازماندهی و دسترسی آسان به جداول پایگاه داده مربوطه آنها وارد می‌شوند.
<div style="font-size: 19px;color: #ff0099;margin-top: 10px;text-align: right;width: 100%;border-bottom: 2px solid #ff0099;padding-bottom: 10px;">سلب مسئولیت امنیت داده</div>
لازم به ذکر است که این پروژه برای محافظت از داده‌های کاربران، اقدامات امنیتی قدرتمندی را پیاده‌سازی نکرده است. بنابراین، هیچ تضمینی برای حفظ حریم خصوصی یا ثبات داده‌های ذخیره شده وجود ندارد. به کاربران توصیه می‌شود که هیچ اطلاعات شخصی یا حساسی را بعنوان کد دسترسی خود یا در محتوای کارت‌های آموزشی شان وارد نکنند.

<!-- Footer -->
</div>
<?php include 'footer.php'; ?>

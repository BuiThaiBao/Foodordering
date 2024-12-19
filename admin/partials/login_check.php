<?php
if (!isset($_SESSION['user'])) {
    $_SESSION['no-login-message'] = "<div class='error text-center'>Bạn phải đăng nhập để vào trang quản lýlý</div>";
    header('location:' . SITEURL . 'admin/login.php');
}


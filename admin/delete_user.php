<?php

include('../config/constants.php');
$id = $_GET['id'];

$sql = "Delete from users where id = $id";

$res = mysqli_query($conn, $sql);

if ($res == true) {
    $_SESSION['delete'] = "<div class='success' >Xóa user thành công</div>";
    header('location:' . SITEURL . '/admin/manage_user.php');
} else {
    $_SESSION['delete'] = "<div class='error' > Lỗi xóa user</div>";
    header('location:' . SITEURL . '/admin/manage_user.php');
}

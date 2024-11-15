<?php
include('../config/constants.php');
$id = $_GET['id'];

$sql = "Delete from tbl_admin where id =$id ";
$res = mysqli_query($conn, $sql);

if ($res == true) {
    $_SESSION['delete'] = "<div class='success' >Xóa nhân viên thành công </div>";
    header('location:' . SITEURL . '/admin/manage_admin.php');
} else {
    $_SESSION['delete'] = "<div class='error' >Xóa nhân viên thất bại </div>";
    header('location:' . SITEURL . '/admin/manage_admin.php');
}

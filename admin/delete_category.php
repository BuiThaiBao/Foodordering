<?php
include('../config/constants.php');
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    if ($image_name != "") {
        $remove_path = "../images/category/" . $image_name;
        $remove = unlink($remove_path);
        if ($remove == false) {
            $_SESSION['remove'] = "<div class='error'>Xóa ảnh thất bại</div>";
            header('location:' . SITEURL . 'admin/manage_category.php');
            die();
        }
    }
    $sql = "DELETE FROM tbl_category WHERE id = $id ";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Xóa danh mục thành công</div>";
        header('location:' . SITEURL . 'admin/manage_category.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Xóa danh mục thât bại</div>";
        header('location:' . SITEURL . 'admin/manage_category.php');
    }
} else {

    header('location:' . SITEURL . 'admin/manage_category.php');
}

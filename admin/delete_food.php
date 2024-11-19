<?php
include('../config/constants.php');
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    if ($image_name != "") {
        $path = "../images/food/" . $image_name;
        $remove = unlink($path);
        if ($remove == false) {
            $_SESSION['upload'] = "<div class='error'>Lỗi xóa ảnh</div>";
            header('location:' . SITEURL . 'admin/manage_food.php');
            die();
        }
    }
    $sql = "DELETE FROM tbl_food WHERE id = $id ";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Xóa món ăn thành công</div>";
        header('location:' . SITEURL . 'admin/manage_food.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Xóa món ăn thất bại</div>";
        header('location:' . SITEURL . 'admin/manage_food.php');
    }
} else {
    header('location:' . SITEURL . 'admin/manage_food.php');
}

<?php
include('partials-front/menu.php');

if (!isset($_SESSION['u_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}
if (isset($_POST['food_id']) && isset($_POST['quantity'])) {
    $food_id = $_POST['food_id'];
    $quantity = intval($_POST['quantity']); // Lấy số lượng từ form và chuyển thành số nguyên

    // Kiểm tra nếu giỏ hàng chưa có sản phẩm, tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng thì tăng số lượng, nếu chưa thì thêm mới
    if (isset($_SESSION['cart'][$food_id])) {
        $_SESSION['cart'][$food_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$food_id] = array('quantity' => $quantity);
    }
    $_SESSION['add_cart_success'] = "<div class='success'>Thêm vào giỏ thành công</div>";
    // Phản hồi thành công hoặc chuyển hướng người dùng nếu cần
    header('Location: ' . $_SERVER['HTTP_REFERER']); // Quay lại trang hiện tại sau khi thêm vào giỏ hàng
    exit;
}

<?php
include('../config/constants.php');
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $stmt = $conn->prepare("UPDATE tbl_order_details SET status = 3 WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("UPDATE tbl_order SET status = 3 WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        $_SESSION['cancel_order'] = "<div class='fail'>Hủy đơn hàng thành công</div>";
        header('Location: ' . SITEURL . 'admin/manage_order.php');
        exit;
    } else {
        echo "Lỗi khi cập nhật thông tin đơn hàng.";
    }
    $stmt->close();
} else {
    echo "Đơn hàng không hợp lệ hoặc không tồn tại.";
}
?>

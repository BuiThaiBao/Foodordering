<?php
include('partials-front/menu.php'); 

// Lấy ID người dùng hiện tại
$u_id = $_SESSION['u_id'];

// Lấy thông tin đơn hàng của người dùng
$sql = "SELECT * FROM tbl_order WHERE u_id = $u_id";
$res = mysqli_query($conn, $sql);
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<h2>Danh sách đơn hàng của bạn</h2>
<table class="table">
    <tr>
        <th>STT</th>
        <th>Mã đơn hàng</th>
        <th>Ngày đặt</th>
        <th>Tổng số tiền</th>
        <th>Phương thức thanh toán</th>
        <th>Tình trạng</th>
        <th>Chi tiết</th>
        <th>Hành động</th>
    </tr>

<?php
$stt = 1;
while ($row = mysqli_fetch_assoc($res)) {
    $status = ($row['status'] == 0) ? 'Đã nhận hàng' : (($row['status'] == 1) ? 'Đang đặt hàng' : 'Đã hủy');
    $payment_method_id = $row['payment_method'];

    // Lấy tên phương thức thanh toán từ tbl_payment
    $payment_sql = "SELECT pm_name FROM tbl_payment WHERE pm_id = $payment_method_id";
    $payment_res = mysqli_query($conn, $payment_sql);
    $payment_row = mysqli_fetch_assoc($payment_res);
    $payment_name = $payment_row['pm_name'];
?>

    <tr>
        <td><?= $stt++ ?></td>
        <td><?= $row['id'] ?></td>
        <td><?= $row['order_date'] ?></td>
        <td><?= number_format($row['total_amount'], 0, ',', '.') ?> VNĐ</td>
        <td><?= $payment_name ?></td>
        <td><?= $status ?></td>
        <td>
            <a href="order_details.php?order_id=<?= $row['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
        </td>
        <td>
            <a href="cancel_order.php?order_id=<?= $row['id'] ?>" class="btn btn-danger">Hủy đơn hàng</a>
        </td>
    </tr>
<?php
}
?>

</table>

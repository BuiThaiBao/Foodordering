<?php
include('partials-front/menu.php'); 

// Lấy ID người dùng hiện tại
$u_id = $_SESSION['u_id'];
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
// Lấy thông tin đơn hàng của người dùng
$sql = "SELECT * FROM tbl_order WHERE u_id = $u_id";
if ($filter_status !== '') {
    $sql .= " AND status = $filter_status";
}
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
<form method="GET" action="">
    <label for="status">Lọc theo trạng thái:</label>
    <select name="status" id="status">
        <option value="">Tất cả</option>
        <option value="1" <?= $filter_status === '1' ? 'selected' : '' ?>>Đang đặt hàng</option>
        <option value="2" <?= $filter_status === '2' ? 'selected' : '' ?>>Đang giao hàng</option>
        <option value="0" <?= $filter_status === '0' ? 'selected' : '' ?>>Giao hàng thành công</option>
        <option value="3" <?= $filter_status === '3' ? 'selected' : '' ?>>Đã hủy</option>
    </select>
    <button type="submit" class="btn btn-primary">Lọc</button>
</form>
<table class="table">
    <tr>
      
        <th>Mã đơn hàng</th>
        <th>Ngày đặt</th>
        <th>Tổng số tiền</th>
        <th>Phương thức thanh toán</th>
        <th>Tình trạng</th>
        <th>Chi tiết</th>
        <th>Hành động</th>
        <th>Xác nhận</th>
    </tr>

<?php
while ($row = mysqli_fetch_assoc($res)) {
    $status = ($row['status'] == 0) ? 'Giao hàng thành công' : 
          (($row['status'] == 1) ? 'Đang đặt hàng' : 
          (($row['status'] == 2) ? 'Đang giao hàng' : 
          'Đã hủy'));
    $payment_method_id = $row['payment_method'];

    // Lấy tên phương thức thanh toán từ tbl_payment
    $payment_sql = "SELECT pm_name FROM tbl_payment WHERE pm_id = $payment_method_id";
    $payment_res = mysqli_query($conn, $payment_sql);
    $payment_row = mysqli_fetch_assoc($payment_res);
    $payment_name = $payment_row['pm_name'];
?>

    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['order_date'] ?></td>
        <td><?= number_format($row['total_amount'], 0, ',', '.') ?> VNĐ</td>
        <td><?= $payment_name ?></td>
        <td><?= $status ?></td>
        <td>
            <a href="order_details.php?order_id=<?= $row['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
        </td>
        <td>
        <?php if ($row['status'] == 1): ?>
            <a href="cancel_order.php?order_id=<?= $row['id'] ?>" class="btn btn-danger">Hủy đơn hàng</a>
            <?php endif; ?>
        </td>
        <td><?php if ($row['status'] == 2): ?>
                <a href="confirm_order.php?order_id=<?= $row['id'] ?>" class="btn btn-primary">Đã nhận được hàng</a>
            <?php endif; ?>
        </td>
        <td></td>
    </tr>
<?php
}
?>

</table>

<?php
include("partials/header.php");
$order_id = $_GET['order_id'];


$sql = "SELECT * FROM tbl_order WHERE id = $order_id  ";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$u_id = $row ['u_id'];

if ($res && mysqli_num_rows($res) > 0) {
    $order = mysqli_fetch_assoc($res);

    $details_sql = "SELECT * FROM tbl_order_details WHERE order_id = $order_id";
    $details_res = mysqli_query($conn, $details_sql);
} else {
    $_SESSION['error'] = "Không tìm thấy đơn hàng.";
    header('location: myorders.php');
    exit();
}
?>

<h2>Chi tiết đơn hàng</h2>
<table class="table">
    <tr>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Size</th>
        <th>Ghi chú</th>
        <th>Số lượng</th>
        <th>Đơn giá</th>
        <th>Tổng</th>
    </tr>

<?php
while ($row = mysqli_fetch_assoc($details_res)) {
    $food_sql = "SELECT title, price ,image_name FROM tbl_food WHERE id = {$row['food_id']}";
    $food_res = mysqli_query($conn, $food_sql);
    $food = mysqli_fetch_assoc($food_res);
    $total_price = $row['quantity'] * $food['price'];
?>

    <tr>
        <td><?= htmlspecialchars($food['title']) ?></td>
        <td><img src="<?= SITEURL . 'images/food/' . $food['image_name'] ?>" alt="<?= htmlspecialchars($food['title']) ?>" style="width: 200px; height: 200px;"></td>
        <td><?= htmlspecialchars($row['size']) ?></td>
        <td><?= htmlspecialchars($row['note']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= number_format($food['price'], 0, ',', '.') ?> VNĐ</td>
        <td><?= number_format($total_price, 0, ',', '.') ?> VNĐ</td>
    </tr>
<?php
}
?>

</table>
<?php
$sql2 = "SELECT * FROM users Where id = $u_id";
$res2 = mysqli_query($conn,$sql2);
while ($row2 = mysqli_fetch_array($res2)) {
    $customer_name = $row2['customer_name'];
    $customer_email = $row2['customer_email'];
    $customer_phone = $row2['customer_contact'];
    $customer_address = $row2['customer_address'];
}
?>

<h2>Thông tin khách hàng</h2>

<p>Họ tên: <?php echo $customer_name; ?></p>

<p>Email: <?php echo $customer_email; ?> </p>
<p>Số điện thoại: <?php echo $customer_phone; ?></p>

<p>Địa chỉ:  <?php echo $customer_address; ?></p>
<a href="process_order.php?order_id=<?php echo $order_id ?>" class="btn btn-secondary">Xác nhận đơn hàng</a>

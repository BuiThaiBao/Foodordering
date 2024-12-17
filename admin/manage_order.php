<?php
include("partials/header.php");
$sql = " SELECT tbl_order.*,users.customer_name FROM tbl_order JOIN users ON tbl_order.u_id = users.id where tbl_order.status IN (1,2) ";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
           
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng số tiềntiền</th>
            <th>Phương thức thanh toán</th>
            <th>Tình trạng</th>
            <th>Chi tiết đơn hàng</th>
            <th>Hủy</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($res)) {
            $customer_name = $row['customer_name'];
            $order_date = $row['order_date'];
            $total_amount = $row['total_amount'];
            $payment_method_id = $row['payment_method'];
            $payment_sql = "SELECT pm_name FROM tbl_payment WHERE pm_id = $payment_method_id";
            $payment_res = mysqli_query($conn, $payment_sql);
            $payment_row = mysqli_fetch_assoc($payment_res);
            $payment_name = $payment_row['pm_name'];
            $status = (($row['status'] == 1) ? 'Đang đặt hàng' : 'Đang giao hàng');
        ?>
        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $customer_name;?></td>
            <td><?php echo $order_date;?></td>
            <td><?php echo number_format($total_amount, 0, '', '.');?></td>
            <td><?php echo $payment_name;?></td>
            <td><?php echo $status;?></td>
            <td><a href="view_order_detail.php?order_id=<?php echo $row['id'];?>">Xem chi tiết</a></td>
            <td><a href="cancel_order.php?id=<?php echo $row['id'];?>">Hủy</a></td>
        </tr>
        
        <?php
        }
        ?>

    </table>
</body>

</html>
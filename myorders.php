<?php
include('partials-front/menu.php');
$u_id = $_SESSION['u_id'];
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
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
<div class="breadcrumb">
    <a href="index.php">Trang chủ</a> > <span>Đơn hàng</span>
</div>
<hr class="divider">

<div class="cart-container">
<div class="form-filter">
<form method="GET" action=""  >
    
    <select name="status" id="status" >
        <option value="">Tất cả</option>
        <option value="1" <?= $filter_status === '1' ? 'selected' : '' ?>>Đang đặt hàng</option>
        <option value="2" <?= $filter_status === '2' ? 'selected' : '' ?>>Đang giao hàng</option>
        <option value="0" <?= $filter_status === '0' ? 'selected' : '' ?>>Giao hàng thành công</option>
        <option value="3" <?= $filter_status === '3' ? 'selected' : '' ?>>Đã hủy</option>
    </select>
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>
</div>
<h2 class="title-cart"> Đơn hàng của bạn</h2>
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
            $status = ($row['status'] == 0) ? 'Giao hàng thành công' : (($row['status'] == 1) ? 'Đang đặt hàng' : (($row['status'] == 2) ? 'Đang giao hàng' :
                        'Đã hủy'));
            $payment_method_id = $row['payment_method'];

            $payment_sql = "SELECT pm_name FROM tbl_payment WHERE pm_id = $payment_method_id";
            $payment_res = mysqli_query($conn, $payment_sql);
            $payment_row = mysqli_fetch_assoc($payment_res);
            $payment_name = $payment_row['pm_name'];
        ?>

            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td><?= number_format($row['total_amount'], 0, ',', '.') ?><u>đ</u></td>
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
                
            </tr>
        <?php
        }
        ?>

    </table>
</div>
<style>
    .cart-container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

h2 {
    text-align: left;
    font-size: 1.8em;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    background-color: #fff;
}

/* Table header styling */
.table th {
    background-color: #428b16;
    color: white;
    padding: 12px;
    text-align: center;
    border: 1px solid #ebebeb;
    font-weight: bold;
}

.table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ebebeb;
}

.table td img {
    width: 60px;
    height: auto;
    border-radius: 8px;
}
.btn-primary {
    background-color: #51aa1b;
    color: white;
    height: 50px;
    border: none;
}

.btn-primary:hover, .btn-success:hover {
    background-color: #4e9a1a;
}
.btn-danger {
    background-color: red;
    color: white;
}

.btn-danger:hover {
    background-color: #d9534f;
}

.btn {
    padding: 5px 15px;
    text-align: center;
    border: none;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.breadcrumb {
        padding: 10px 20px 0 ;
        font-size: 14px;
        border-radius: 5px;
    }

    .breadcrumb a {
        padding-left: 120px;
        text-decoration: none;
        color:black;
        padding-right: 10px;

    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb span {
        padding-left: 10px;
        color: black;
        font-size: 14px;
        font-weight:bolder;
    }
    .divider {
  border: none;
  border-top: 1px solid #ccc;
  margin: 0;
}
.title-cart{
    
    font-size: 2em;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    margin-top: 20px;
}
.form-filter{
    position: relative;
    justify-content: flex-end;
    width: 300px;

}


</style>
<?php
include('partials-front/footer.php');
?>
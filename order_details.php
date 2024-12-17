<?php
include('partials-front/menu.php'); 

// Lấy ID đơn hàng từ URL
$order_id = $_GET['order_id'];

// Lấy thông tin chi tiết của đơn hàng
$sql = "SELECT * FROM tbl_order WHERE id = $order_id AND u_id = {$_SESSION['u_id']}";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $order = mysqli_fetch_assoc($res);

    // Lấy thông tin chi tiết của đơn hàng từ tbl_order_details
    $details_sql = "SELECT * FROM tbl_order_details WHERE order_id = $order_id";
    $details_res = mysqli_query($conn, $details_sql);
} else {
    $_SESSION['error'] = "Không tìm thấy đơn hàng.";
    header('location: myorders.php');
    exit();
}
?>
<div class="breadcrumb">
<a style="padding-left: 120px;" href="index.php">Trang chủ</a>><a href="myorders.php">Đơn hàng</a>><span>Chi tiết đơn hàng</span>
</div>
<hr class="divider">

<div class="cart-container">
<h2 title-cart>Chi tiết đơn hàng</h2>
<table class="table">
    <tr>
        
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Size</th>
        <th>Ghi chú</th>
        <th>Số lượng</th>
        <th>Đơn giá</th>
        <th>Tổng</th>
        <th>Đánh giá</th>
    </tr>

<?php
while ($row = mysqli_fetch_assoc($details_res)) {
    // Lấy thông tin sản phẩm từ tbl_food
    $food_sql = "SELECT title, price ,image_name FROM tbl_food WHERE id = {$row['food_id']}";
    $food_res = mysqli_query($conn, $food_sql);
    $food = mysqli_fetch_assoc($food_res);
    $total_price = $row['quantity'] * $food['price'];
?>

    <tr>
        <td><?= htmlspecialchars($food['title']) ?></td>
        <td><img src="<?= SITEURL . 'images/food/' . $food['image_name'] ?>" alt="<?= htmlspecialchars($food['title']) ?>"></td>
        <td><?= htmlspecialchars($row['size']) ?></td>
        <td><?= htmlspecialchars($row['note']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= number_format($food['price'], 0, ',', '.') ?> VNĐ</td>
        <td><?= number_format($total_price, 0, ',', '.') ?> VNĐ</td>
        <td>
        <?php if ($row['status'] == 0): ?>
            <a href="user_comment.php?food_id=<?= $row['food_id'] ?>" class="btn btn-primary">Đánh giá </a>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
?>

</table>
</div>
<span style="padding-left:44%">
<a href="myorders.php" class="btn btn-primary" style="padding-top: 15px;" >Quay lại danh sách đơn hàng</a></span>
<style>
    .table tr td {
    padding-top: 50px;
    align-items: center;
}
.table tr td a{
    padding-top: 10px;
    align-items: center;
}
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
    width: 100px;
    height: auto;
    border-radius: 8px;
}
.btn-primary {
    background-color: #51aa1b;
    color: white;
    height: 50px;
    border: none;
    align-items: center;
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
        padding-left: 10px;
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
</style>

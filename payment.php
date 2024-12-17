<?php
include('partials-front/menu.php');
$u_id = $_SESSION['u_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart'])) {
    $cart = $_POST['cart'];
    $total_price = $_POST['total_price'];
    $note = $_POST['note'];
?>
    <div class="breadcrumb">
        <a style="padding-left: 120px;" href="index.php">Trang chủ</a>><a href="view_cart.php">Giỏ hàng</a>><span>Thanh toán</span>
    </div>
    <hr class="divider">
    <h2>Thông tin đặt hàng</h2>

    <table class="table">
        <tr>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Size</th>
            <th>Ghi chú</th>
            <th>Tổng</th>
        </tr>

        <?php
        $grand_total = 0;

        foreach ($cart as $food_id => $details) {
            $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
            $stmt->bind_param("i", $food_id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($product = $res->fetch_assoc()) {
                $title = $product['title'];
                $image_name = $product['image_name'];
                $price = $product['price'];
                $quantity = $details['quantity'];
                $size = $details['size'];
                $item_total = $price * $quantity;

                if ($size == 'M') {
                    $item_total *= 1.10;
                } elseif ($size == 'L') {
                    $item_total *= 1.20;
                }
        ?>
                <tr>
                    <td width="250px"><?= htmlspecialchars($title) ?></td>
                    <td style="width: 200px">
                        <?php if ($image_name != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image" width="150px">
                        <?php } else { ?>
                            <div class="error">Image not available.</div>
                        <?php } ?>
                    </td>
                    <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                    <td><?= htmlspecialchars($quantity) ?></td>
                    <td><?= htmlspecialchars($size) ?></td>
                    <td><?= htmlspecialchars($note) ?></td>
                    <td><?= number_format($item_total, 0, ',', '.') ?> VND</td>
                </tr>
        <?php
                $grand_total += $item_total;
            }
            $stmt->close();
        }
        ?>
        <tr>
            <td colspan='4'><strong>Tổng cộng</strong></td>
            <td></td>
            <td><strong><?= number_format($grand_total, 0, ',', '.') ?> VND</strong></td>
        </tr>
    </table>
    <form action="process_payment.php" method="post">

        <input type="hidden" name="cart" value='<?= json_encode($cart) ?>'>
        <input type="hidden" name="note" value='<?= json_encode($note) ?>'>
        <input type="hidden" name="total_price" value="<?= $grand_total ?>">
        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán:</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <?php
                $sql = "SELECT * FROM tbl_payment";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $pm_id = $row['pm_id'];
                        $pm_name = $row['pm_name'];
                        if ($pm_id == 1) {
                            $icon = '<i class="fa-solid fa-truck"></i>';
                        } elseif ($pm_id == 2) {
                            $icon = '<i class="fa-solid fa-university"></i>';
                        } elseif ($pm_id == 3) {
                            $icon = '<i class="fa-solid fa-wallet"></i>';
                        } else {
                            $icon = '';
                        }
                        echo "<option value='$pm_id'>$icon $pm_name</option>";
                    }
                } else {
                    echo "<option value=''>Không có phương thức thanh toán nào</option>";
                }
                ?>
            </select>

        </div>

        <input type="submit" class="btn btn-success" value="Xác nhận đặt hàng"></input>
    </form>
<?php
} else {
?>
    <p>Không có thông tin giỏ hàng.</p>
    <style>
        /* Tổng quan */
        h2 {
            color: #58B747;
            text-align: center;
            margin-top: 20px;
            font-size: 28px;
            margin-bottom: 30px;
        }

        /* Bảng thông tin đặt hàng */
        .table {
            width: 90%;
            margin: 0 auto 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #428B16;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eaeaea;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #e9f8e9;
        }

        .food-image {
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Form đặt hàng */
        .form-group {
            margin: 20px auto;
            width: 50%;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #58B747;
            outline: none;
            box-shadow: 0 0 5px rgba(88, 183, 71, 0.5);
        }

        /* Nút xác nhận */
        .btn {
            display: block;
            width: 50%;
            margin: 0 auto 20px;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            color: #fff;
            background-color: #58B747;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #4ea03f;
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* Thông báo lỗi */
        .error {
            color: #ff4c4c;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Tổng cộng */
        strong {
            color: #58B747;
            font-size: 18px;
        }

        .breadcrumb {
            padding: 10px 20px 0;
            font-size: 14px;
            border-radius: 5px;
        }

        .breadcrumb a {
            padding-left: 10px;
            text-decoration: none;
            color: black;
            padding-right: 10px;

        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            padding-left: 10px;
            color: black;
            font-size: 14px;
            font-weight: bolder;
        }

        .divider {
            border: none;
            border-top: 1px solid #ccc;
            margin: 0;
        }
    </style>
<?php
}
include('partials-front/footer.php');
?>
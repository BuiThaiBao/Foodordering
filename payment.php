<?php
include('partials-front/menu.php');
$u_id = $_SESSION['u_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart'])) {
    $cart = $_POST['cart'];
    $total_price = $_POST['total_price'];
    $note = $_POST['note'];
?>

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
            <select name="payment_method" id="payment_method" class="form-control">
                <?php
                $sql = "SELECT * FROM tbl_payment";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $pm_id = $row['pm_id'];
                        $pm_name = $row['pm_name'];
                        echo "<option value='$pm_id'>$pm_name</option>";
                    }
                } else {
                    echo "<option value=''>Không có phương thức thanh toán nào</option>";
                }
                ?>
            </select>     
        </div>
        <input type="hidden" name="cart" value='<?= json_encode($cart) ?>'>
         <input type="hidden" name="payment_method" value="<?= $pm_id ?>">
        <input type="submit" class="btn btn-success" value="Xác nhận đặt hàng"></input>
    </form>
<?php
} else {
?>
    <p>Không có thông tin giỏ hàng.</p>
<?php
}

include('partials-front/footer.php');
?>
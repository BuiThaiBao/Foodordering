<?php
include('partials-front/menu.php');
?>
<html>
<style>
    .cart-container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    /* Tiêu đề */
    h2 {
        text-align: left;
        font-size: 1.8em;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
    }

    /* Bảng giỏ hàng */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        background-color: #fff;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ebebeb;
    }

    .table th {
        background-color: #f5f5f5;
        color: #333;
        font-weight: bold;
    }

    /* Thông tin sản phẩm */
    .table td img {
        width: 60px;
        height: auto;
        border-radius: 8px;
    }

    /* Giá và tổng tiền */
    .table .food-price,
    .table .food-total {
        font-weight: 600;
        color: #ff5722;
    }

    /* Ô nhập số lượng */
    input[type="number"] {
        width: 50px;
        padding: 5px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: center;
    }

    /* Nút hành động */
    .btn {
        padding: 10px 20px;
        text-align: center;
        border: none;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    /* Nút cập nhật giỏ hàng */
    .btn-primary {
        background-color: #ff5722;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #e64a19;
    }

    /* Nút thanh toán */
    .btn-success {
        background-color: #4caf50;
        color: #fff;
        margin-left: 10px;
    }

    .btn-success:hover {
        background-color: #43a047;
    }

    /* Nút xóa sản phẩm */
    .btn-danger {
        background-color: #f44336;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #d32f2f;
    }

    /* Nút xóa toàn bộ giỏ hàng */
    .btn-empty-cart {
        background-color: #9e9e9e;
        color: #fff;
        margin-top: 15px;
        display: inline-block;
    }

    .btn-empty-cart:hover {
        background-color: #757575;
    }

    /* Dòng tổng cộng */
    .table tr:last-child td {
        font-weight: bold;
        font-size: 1.1em;
        color: #333;
    }

    /* Khoảng cách giữa các nút */
    .btn-container {
        text-align: right;
        margin-top: 20px;
    }
</style>

<h2>Giỏ hàng của bạn</h2>
<form action="payment.php" method="post">
    <div class="cart-container">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
            <table class='table'>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Tổng</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>

                <?php $total_price = 0;
                foreach ($_SESSION['cart'] as $food_id => $details) {
                    if (!is_numeric($food_id)) continue;
                    $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
                    $stmt->bind_param("i", $food_id);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($product = $res->fetch_assoc()) {
                        $title = $product['title'];
                        $image_name = $product['image_name'];
                        $price = $product['price'];
                        $quantity = $details['quantity'];
                        $size = isset($details['size']) ? $details['size'] : 'S';
                        $item_total = $price * $quantity;

                        if ($size == 'M') $item_total *= 1.10;
                        elseif ($size == 'L') $item_total *= 1.20; ?>

                        <tr>
                            <td><?= $title ?></td>
                            <td>

                                <?php if ($image_name != "") { ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image">
                                <?php } else { ?>
                                    <div class="error">Image not available.</div>
                                <?php } ?>

                            </td>
                            <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                            <td>
                                <input type='number' name='quantity[<?= $food_id ?>]' value='<?= $quantity ?>' min='1' style='width: 50px;' onchange='updateQuantity(this, <?= $food_id ?>)'>
                            </td>
                            <td>
                                <select name='size[<?= $food_id ?>]' onchange='updateSize(this, <?= $food_id ?>)'>
                                    <option value='S' <?= ($size == 'S' ? 'selected' : '') ?>>S</option>
                                    <option value='M' <?= ($size == 'M' ? 'selected' : '') ?>>M</option>
                                    <option value='L' <?= ($size == 'L' ? 'selected' : '') ?>>L</option>
                                </select>
                            </td>
                            <td id='item-total-<?= $food_id ?>'><?= number_format($item_total, 0, ',', '.') ?> VND</td>
                            <td>
                                <textarea name="note" cols="30" rows="5" placeholder="Ghi chú cho cửa hàng"></textarea>
                            </td>
                            <td>
                                <a href='remove_cart.php?food_id=<?= $food_id ?>' class='btn btn-danger'>Xóa</a>
                            </td>
                        </tr>

                        <?php $total_price += $item_total; ?>
                    <?php } ?>
                    <?php $stmt->close(); ?>
                <?php } ?>

                <?php foreach ($_SESSION['cart'] as $food_id => $details) { ?>
                    <input type="hidden" name="cart[<?= $food_id ?>][quantity]" value="<?= $details['quantity'] ?>">
                    <input type="hidden" name="cart[<?= $food_id ?>][size]" value="<?= (isset($details['size']) ? $details['size'] : 'S') ?>">
                <?php } ?>

                <tr>
                    <td colspan='4'><strong>Tổng cộng</strong></td>
                    <td id='total-price'><strong><?= number_format($total_price, 0, ',', '.') ?> VND</strong></td>
                    <td></td>
                </tr>


                <input type="hidden" name="total_price" value="<?= $total_price ?>">

            </table>
        <?php } else { ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php } ?>
    </div>
    <input type="hidden">
    <button type="submit" class="btn btn-success">Đặt hàng</button>
</form>
<button class='btn btn-primary' onclick='location.reload();'>Cập nhật giỏ hàng</button>




















<script>
    // Hàm cập nhật số lượng và tính lại tổng giá
    function updateQuantity(input, food_id) {
        let quantity = input.value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                document.getElementById(`item-total-${food_id}`).innerText = response.item_total + " VND";
                document.getElementById('total-price').innerText = response.total_price + " VND";
            }
        };

        xhr.send("food_id=" + food_id + "&quantity=" + quantity);
    }

    function updateSize(select, food_id) {
        let size = select.value;
        let quantity = document.querySelector(`input[name="quantity[${food_id}]"]`).value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                document.getElementById(`item-total-${food_id}`).innerText = response.item_total + " VND";
                document.getElementById('total-price').innerText = response.total_price + " VND";
            }
        };

        xhr.send("food_id=" + food_id + "&quantity=" + quantity + "&size=" + size);
    }
</script>

</html>

<?php
include('partials-front/footer.php');
?>
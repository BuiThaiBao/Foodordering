<?php
include('partials-front/menu.php');
// Kết nối cơ sở dữ liệu
?>
<html>
<style>
    /* Styles similar to your original code */
    /* Adjust or add styles here if needed */
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

<div class="cart-container">
    <?php
    // Kiểm tra nếu giỏ hàng không rỗng
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        echo "<table class='table'>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>";

        $total_price = 0;

        foreach ($_SESSION['cart'] as $food_id => $details) {
            if (!is_numeric($food_id)) {
                continue;
            }

            // Truy vấn thông tin sản phẩm
            $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
            $stmt->bind_param("i", $food_id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($product = $res->fetch_assoc()) {
                $title = $product['title'];
                $price = $product['price'];
                $quantity = $details['quantity'];
                $size = isset($details['size']) ? $details['size'] : 'S'; // Mặc định là 'S'
                $item_total = $price * $quantity;

                // Tính giá theo kích thước
                if ($size == 'M') {
                    $item_total *= 1.10;  // Tăng 10% cho size M
                } elseif ($size == 'L') {
                    $item_total *= 1.20;  // Tăng 20% cho size L
                }

                echo "<tr>
                        <td>$title</td>
                        <td>" . number_format($price, 0, ',', '.') . " VND</td>
                        <td>
                            <input type='number' name='quantity[$food_id]' value='$quantity' min='1' style='width: 50px;' onchange='updateQuantity(this, $food_id)'>
                        </td>
                        <td>
                            <select name='size[$food_id]' onchange='updateSize(this, $food_id)'>
                                <option value='S' " . ($size == 'S' ? 'selected' : '') . ">S</option>
                                <option value='M' " . ($size == 'M' ? 'selected' : '') . ">M</option>
                                <option value='L' " . ($size == 'L' ? 'selected' : '') . ">L</option>
                            </select>
                        </td>
                        <td id='item-total-$food_id'>" . number_format($item_total, 0, ',', '.') . " VND</td>
                        <td>
                            <a href='remove_cart.php?food_id=$food_id' class='btn btn-danger'>Xóa</a>
                        </td>
                    </tr>";

                $total_price += $item_total;
            }
            $stmt->close();
        }

        echo "<tr>
                <td colspan='4'><strong>Tổng cộng</strong></td>
                <td id='total-price'><strong>" . number_format($total_price, 0, ',', '.') . " VND</strong></td>
                <td></td>
              </tr>";
        echo "</table>";
        echo "<button class='btn btn-primary' onclick='location.reload();'>Cập nhật giỏ hàng</button>";
        echo "<a href='checkout.php' class='btn btn-success'>Thanh toán</a>";
    } else {
        echo "<p>Giỏ hàng của bạn đang trống.</p>";
    }
    ?>
</div>


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
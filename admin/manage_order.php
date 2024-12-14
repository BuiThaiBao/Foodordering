<?php
include("partials/header.php");
?>
<style>
    .wrapper {

        padding: 1%;
        width: 95%;
        margin: 0 auto;
    }
</style>
<div class="main-content ">
    <div class="wrapper">
        <h1>Quản lý đơn hàng</h1>


        <br /> <br /> <br />

        <?php

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>
        <br>
        <br>
        <table>
            <tr>
                <th>STT</th>
                <th>Món ăn</th>
                <th>Giá</th>
                <th>SL</th>
                <th>Tổng thanh toán </th>
                <th>Ngày đặt </th>
                <th>Trạng thái</th>
                <th>Ghi chú </th>
                <th>Người nhận</th>
                <th>Liên hệ</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Người đặt</th>
                <th>Action</th>

            </tr>

            <?php

            $sql = "Select tbl_order.*,users.customer_name from tbl_order 
            join users on tbl_order.u_id = users.id order by id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $stt = 1;


            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $note = $row['note'];
                    $name = $row['name'];
                    $contact = $row['contact'];
                    $email = $row['email'];
                    $address = $row['address'];
                    $u_name = $row['customer_name'];
            ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>

                            <?php

                            if ($status == "Order") {
                                echo "<label>$status</label>";
                            } elseif ($status == "On Delivery") {
                                echo "<label style='color: orange;'>$status</label>";
                            } elseif ($status == "Delivered") {
                                echo "<label style='color: green;'>$status</label>";
                            } elseif ($status == "Cancelled") {
                                echo "<label style='color: red;'>$status</label>";
                            }
                            ?>
                        </td>
                        <td><?php echo $note; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $contact; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $address; ?></td>
                        <td><?php echo $u_name ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update_order.php?id=<?php echo $id; ?>">Chấp nhận </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='12' class='error'>Không có đơn hàng nào</td></tr>";
            }
            ?>

        </table>
    </div>

</div>

<?php
include("partials/footer.php");
?>
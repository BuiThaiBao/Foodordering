<?php
include("partials/header.php");
?>
<html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .main-content {
        background-color: #fff;
        padding: 20px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    /* Form Container */
    .form-container {
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    textarea.form-control {
        resize: none;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Alerts */
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }
</style>
<div class="main-content">
    <div class="wrapper">
        <h1 class="text-center">Cập nhật đơn hàng</h1>
        <br>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
                $note = $row['note'];
                $name = $row['name'];
                $contact = $row['contact'];
                $email = $row['email'];
                $address = $row['address'];
            } else {
                header('location:' . SITEURL . 'admin/manage_order.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/manage_order.php');
        }
        ?>

        <form action="" method="POST" class="form-container">
            <div class="form-group">
                <label for="food">Món ăn:</label>
                <input type="text" id="food" class="form-control" value="<?php echo $food; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="price">Đơn giá:</label>
                <input type="text" id="price" class="form-control" value="<?php echo $price; ?> VND" readonly>
            </div>
            <div class="form-group">
                <label for="qty">Số lượng:</label>
                <input type="number" name="qty" id="qty" class="form-control" value="<?php echo $qty; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Trạng thái:</label>
                <select name="status" id="status" class="form-control">
                    <option <?php if ($status == "Ordered") echo "selected"; ?> value="Ordered">Đã đặt</option>
                    <option <?php if ($status == "On Delivery") echo "selected"; ?> value="On Delivery">Đang giao hàng</option>
                    <option <?php if ($status == "Delivered") echo "selected"; ?> value="Delivered">Đã giao</option>
                    <option <?php if ($status == "Cancelled") echo "selected"; ?> value="Cancelled">Đã hủy</option>
                </select>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú:</label>
                <textarea id="note" class="form-control" readonly><?php echo $note; ?></textarea>
            </div>
            <div class="form-group">
                <label for="name">Người nhận:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Liên hệ:</label>
                <input type="text" name="contact" id="contact" class="form-control" value="<?php echo $contact; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <textarea name="address" id="address" class="form-control" required><?php echo $address; ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="note" value="<?php echo $note; ?>">
            <div class="form-actions">
                <input type="submit" name="submit" value="Cập nhật" class="btn btn-primary">
                <a href="<?php echo SITEURL; ?>admin/manage_order.php" class="btn btn-secondary">Hủy bỏ</a>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $status = $_POST['status'];
            $total = $price * $qty;
            $note = $_POST['note'];
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $address = $_POST['address'];

            $sql2 = "UPDATE tbl_order SET
                qty = '$qty',
                total = '$total',
                status = '$status',
                name = '$name',
                contact = '$contact',
                email = '$email',
                address = '$address'
                WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='alert alert-success'>Cập nhật thành công đơn hàng.</div>";
                header('location:' . SITEURL . 'admin/manage_order.php');
            } else {
                $_SESSION['update'] = "<div class='alert alert-danger'>Cập nhật đơn hàng thất bại.</div>";
                header('location:' . SITEURL . 'admin/manage_order.php');
            }
        }
        ?>
    </div>
</div>

</html>
<?php include("partials/footer.php")
?>
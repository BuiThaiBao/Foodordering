<?php
include('partials/header.php');
?>
<html>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
    </div>
    <br><br>
    <?php
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    <form action="" method="POST">
        <table border=1>
            <tr>
                <td>Tên nhân viên:</td>
                <td><input type="text" name="full_name" placeholder="Điền tên của bạn" required></td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" placeholder="Username" required></td>
            </tr>
            <tr>
                <td>Mật khẩu: </td>
                <td>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu: </td>
                <td>
                    <input type="password" name="cf_password" placeholder="Xác nhận mật khẩu" required>
                </td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" placeholder="Email"></td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td><input type="text" name="address" placeholder="Địa chỉ"></td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td><input type="text" name="contact" placeholder="Contact"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Thêm nhân viên">
                </td>
            </tr>
        </table>
    </form>
</div>
</html>
<?php
if (isset($_POST['submit'])) {

    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cf_password = $_POST['cf_password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    if ($password === $cf_password) {
        $hashed_password = md5($password);
        $sql = "INSERT INTO tbl_admin (full_name, username, password, email, address, contact) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $username, $hashed_password, $email, $address, $contact);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['add'] = "<div class='success'>Thêm nhân viên thành công</div>";
                header('location:' . SITEURL . 'admin/manage_admin.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Thêm nhân viên thất bại</div>";
                header('location:' . SITEURL . 'admin/add_admin.php');
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['add'] = "<div class='error'>Mật khẩu không trùng khớp</div>";
        header('location:' . SITEURL . 'admin/add_admin.php');
    }
}
?>
<?php
include('partials/footer.php');
?>

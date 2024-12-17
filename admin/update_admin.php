<?php
include('partials/header.php');
?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Sửa đổi thông tin nhân viên</h1>
    </div>
    <br>
    <br>
    <?php
    $sql = "SELECT * from tbl_admin where id = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $full_name = $row['full_name'];
            $username = $row['username'];
            $email = $row['email'];
            $address = $row['address'];
            $contact = $row['contact'];
        } else {
            header('location' . SITEURL . 'admin/manage_admin.php');
        }
    }
    ?>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
            </tr>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
            </tr>
            <tr>
                <td>Địa chỉ: </td>
                <td><input type="text" name="address" value="<?php echo $address; ?>"></td>
            </tr>
            <tr>
                <td>Số điện thoại : </td>
                <td><input type="text" name="contact" value="<?php echo $contact; ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql2 = "UPDATE tbl_admin SET 
    full_name='$full_name', 
    username='$username',
    email='$email', 
    address='$address', 
    contact='$contact' 
    WHERE id='$id'";
    $res2 = mysqli_query($conn, $sql2);
    if ($res == true) {
        $_SESSION['update'] = "<div class='success' >Thay đổi thông tin thành công </div>";
        header('location:' . SITEURL . 'admin/manage_admin.php');
    } else {
        $_SESSION['update'] = "<div class='error' >Thay đổi thông tin thất bại</div>";
        header('location:' . SITEURL . 'admin/update_admin.php?id=' . $id);
    }
}
?>
<?php
include('partials/footer.php');
?>
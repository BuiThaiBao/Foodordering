<?php
include('partials/header.php');
?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<div class="main-content">
    <h1>Đổi mật khẩu</h1>
    <?php
    if (isset($_SESSION['old_pass_wrong'])) {
        echo $_SESSION['old_pass_wrong'];
        unset($_SESSION['old_pass_wrong']);
    }
    if (isset($_SESSION['pwd-not-match'])) {
        echo $_SESSION['pwd-not-match'];
        unset($_SESSION['pwd-not-match']);
    }
    ?>
    <br><br>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Nhập mật khẩu hiện tại: </td>
                <td><input type="password" name="old_password" placeholder="Mật khẩu hiện tại" required></td>
            </tr>
            <tr>
                <td>Nhập mật khẩu mới: </td>
                <td><input type="password" name="new_password" placeholder="Mật khẩu mới " required></td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu: </td>
                <td><input type="password" name="cf_password" placeholder="Xác nhận mật khẩu" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Đổi mật khẩu">
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $cf_password = md5($_POST['cf_password']);

    $sql = "SELECT * FROM tbl_admin where id = $id and password = '$old_password'";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            if ($new_password == $cf_password) {
                $sql2 = "update tbl_admin set
                password = '$new_password'
                where id = $id";

                $res2 = mysqli_query($conn, $sql2);
                if ($res2 == true) {
                    $_SESSION['change-pwd'] = "<div class='success'>Đổi mật khẩu thành công </div>";
                    header('location:' . SITEURL . 'admin/manage_admin.php');
                } else {
                    $_SESSION['change-pwd'] = "<div class='error'>Đổi mật khẩu thất bại  </div>";
                    header('location:' . SITEURL . 'admin/manage_admin.php');
                }
            } else {
                $_SESSION['pwd-not-match'] = "<div class='error'>Mật khẩu không trùng khớp</div>";
                header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
            }
        } else {
            $_SESSION['old_pass_wrong'] = "<div class='error'>Mật khẩu cũ không đúng</div>";
            header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
        }
    }
}
?>


<?php
include('partials/footer.php');
?>
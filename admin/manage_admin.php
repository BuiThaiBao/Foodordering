<?php
include('partials/header.php')
?>
<?php
if (isset($_SESSION['add'])) {
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
if (isset($_SESSION['delete'])) {
    echo $_SESSION['delete'];
    unset($_SESSION['delete']);
}
if (isset($_SESSION['change-pwd'])) {
    echo $_SESSION['change-pwd'];
    unset($_SESSION['change-pwd']);
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Quản lý nhân viên</h1>
    </div>
    <br>
    <br>
    <br>
    <a href="add_admin.php">Thêm nhân viên</a>
    <table border=1>
        <tr>
            <th>STT</th>
            <th>Tên nhân viên</th>
            <th>Username</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>SĐT</th>
            <th>Chức năng</th>

        </tr>
        <?php
        $sql = "SELECT * from tbl_admin ";
        $res = mysqli_query($conn, $sql);
        $sn = 1;
        if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                    $email = $row['email'];
                    $address = $row['address'];
                    $contact = $row['contact'];
        ?>
                    <tr>
                        <td><?php echo $sn++ ?></td>
                        <td><?php echo $full_name ?></td>
                        <td><?php echo $username ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $address ?></td>
                        <td><?php echo $contact ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>/admin/update_password.php?id=<?php echo $id; ?>">Đổi mật khẩu</a>
                            <a href="<?php echo SITEURL; ?>/admin/update_admin.php?id=<?php echo $id ?>">Cập nhật</a>
                            <a href="<?php echo SITEURL; ?>/admin/delete_admin.php?id=<?php echo $id; ?>" onclick="return confirmDelete();">Xóa</a>
                        </td>
                    </tr>

        <?php
                }
            }
        }


        ?>
    </table>
</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa nhân viên này không?");
    }
</script>

<?php
include("partials/footer.php");
?>
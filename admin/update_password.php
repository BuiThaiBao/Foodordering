<?php
ob_start();

include('partials/header.php');

// Kiểm tra xem có ID người quản trị không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<style>
/* General Styling for the page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.main-content {
    width: 70%;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* CSS for responsive forms */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table td {
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

.success {
    background-color: #28a745;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.error {
    background-color: #dc3545;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}
</style>

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
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="submit" name="submit" value="Đổi mật khẩu">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $cf_password = $_POST['cf_password'];

    if ($new_password === $cf_password) {
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id = ? AND password = ?");
        $old_password_hashed = md5($old_password);
        $stmt->bind_param("is", $id, $old_password_hashed);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $stmt_update = $conn->prepare("UPDATE tbl_admin SET password = ? WHERE id = ?");
            $new_password_hashed = md5($new_password);
            $stmt_update->bind_param("si", $new_password_hashed, $id);
            
            if ($stmt_update->execute()) {
                $_SESSION['change-pwd'] = "<div class='success'>Đổi mật khẩu thành công</div>";
                header('location:' . SITEURL . 'admin/manage_admin.php');
                exit;
            } else {
                $_SESSION['change-pwd'] = "<div class='error'>Đổi mật khẩu thất bại</div>";
                header('location:' . SITEURL . 'admin/manage_admin.php');
                exit;
            }
        } else {
            $_SESSION['old_pass_wrong'] = "<div class='error'>Mật khẩu cũ không đúng</div>";
            header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
            exit;
        }
    } else {
        $_SESSION['pwd-not-match'] = "<div class='error'>Mật khẩu mới không khớp</div>";
        header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
        exit;
    }
}
?>

<?php
include('partials/footer.php');
$conn->close();
?>

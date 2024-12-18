<?php
include('partials-front/menu.php');// File kết nối DB
$showAlert = false;
$showError = false;
$u_id = $_GET['u_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_POST["u_id"]; 
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $cpassword = $_POST["cpassword"];

    $sql = "SELECT password FROM users WHERE id='$u_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($old_password, $hashed_password)) {
            if ($new_password == $cpassword) {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET password='$hash' WHERE id='$u_id'";
                $update_result = mysqli_query($conn, $update_sql);

                if ($update_result) {
                    $_SESSION['success_msg'] = "<div class='success'>Đổi mật khẩu thành công</div>";
                    header("Location: user_profile.php?u_id=" . $u_id);
                    exit;
                } else {
                    $showError = "Lỗi cập nhật mật khẩu, vui lòng thử lại!";
                }
            } else {
                $showError = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            }
        } else {
            $showError = "Mật khẩu cũ không đúng!";
        }
    } else {
        $showError = "Không tìm thấy tài khoản!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Đổi mật khẩu</title>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center text-success">Đổi mật khẩu</h2>

        <!-- Hiển thị thông báo -->
        <?php if ($showAlert): ?>
            <div class="alert alert-success"><?php echo $showAlert; ?></div>
        <?php elseif ($showError): ?>
            <div class="alert alert-danger"><?php echo $showError; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="old_password">Mật khẩu cũ</label>
                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" required>
            </div>
            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
            </div>
            <div class="form-group">
                <label for="cpassword">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Nhập lại mật khẩu mới" required>
            </div>
            <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
            <button type="submit" class="btn btn-success btn-block">Đổi mật khẩu</button>
        </form>
    </div>

    <style>

        h2.text-center {
            color: #28a745;
        }
        .form-control {
            border: 1px solid black !important;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</body>
<?php include('partials-front/footer.php'); ?>
</html>

<?php
include('partials-front/menu.php'); 
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['u_id'])) {
    $u_id = $_GET['u_id'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_POST['u_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $u_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Mật khẩu đã được cập nhật thành công.";
        } else {
            echo "Có lỗi xảy ra, vui lòng thử lại.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "Mật khẩu không khớp, vui lòng thử lại.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <div class="reset-container">
    <h1>Đặt lại mật khẩu</h1>
    
    <form method="POST" action="reset_password.php">
        <input type="hidden" name="u_id" value="<?php echo htmlspecialchars($u_id); ?>">
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" name="new_password" id="new_password" class="form-control form-control-2" required>
        <label for="confirm_password">Xác nhận mật khẩu mới:</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-2" required>
        <div class="button"><button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button></div>
    </form>
    </div>
</body>
</html>
<?php include('partials-front/footer.php'); ?>
<style>
        .reset-container{
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        margin-top: 50px;
        text-align: center;
        margin-bottom: 100px;
    }
    .form-control-2{
        width: 80% !important;
        border: 2px solid black !important;
    }
    .btn-primary {
    background-color: #51aa1b;
    color: white;
    height: 40px;
    border: none;
}

.btn-primary:hover {
    background-color: #4e9a1a;
}
.button{
    padding-top: 30px;
}
label{
    padding :20px;
    color: #4e9a1a;
}
</style>

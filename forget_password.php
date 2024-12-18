<?php
include('partials-front/menu.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE customer_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $u_id = $row['id'];
        $email=$row['customer_email'];
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'baobambilnd@gmail.com'; 
            $mail->Password = 'banu uypw dggg mddq'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('baobambilnd@gmail.com', 'Twelve Shop');
            $mail->addAddress($email);
            $mail->Subject = 'Reset Password';
            $mail->Body = 'Nhấn vào link để reset mật khẩu: http://localhost/Doanweb/reset_password.php?u_id=' . urlencode($u_id);
            $mail->send();
            $_SESSION['send_success'] = "<div class='success'>Xác minh thành công. Vui lòng vào gmail để xác nhận</div>";
        } catch (Exception $e) {
            echo "Không thể gửi email: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['send_fail'] = "<div class='fail'>Email không tồn tại</div>";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<?php
if (isset($_SESSION['send_success'] )) {
    echo '<div class="alert alert-success">' . $_SESSION['send_success']  . '</div>';
    unset($_SESSION['send_success'] );
}
if (isset($_SESSION['send_fail'] )) {
    echo '<div class="alert alert-warning">' . $_SESSION['send_fail']  . '</div>';
    unset($_SESSION['send_fail'] );
}
?>
<div class="reset-container">
<form method="POST" >
    <label>Nhập email để khôi phục mật khẩu</label>
    <br>
    <input type="email" name="email" required class="form-control form-control-2" placeholder="Email của bạn"> 
    <div class="button"><button type="submit" class="btn btn-primary" >Xác nhận</button></div>
</form>
</div>
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
    .form-control{
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
    padding-top: 20px;
}
label{
    color :  #51aa1b;
    font-size :20px;
    padding-bottom: 20px;
}
</style>

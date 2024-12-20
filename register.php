<?php
include('partials-front/menu.php'); 
$showAlert = false;
$showError = false;
$exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $customer_contact = $_POST["customer_contact"];
    $customer_address = $_POST["customer_address"];

    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $showError = "Địa chỉ email không hợp lệ.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? OR customer_email=?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $customer_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($result);
        if ($num == 0) {
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, 
                    "INSERT INTO users (username, password, customer_name, customer_image, customer_email, customer_contact, customer_address, created_at) 
                    VALUES (?, ?, ?, 'avt_default.jpg', ?, ?, ?, current_timestamp())"
                );
                mysqli_stmt_bind_param($stmt, "ssssss", $username, $hash, $customer_name, $customer_email, $customer_contact, $customer_address);
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    $showAlert = true;
                } else {
                    $showError = "Đã xảy ra lỗi khi tạo tài khoản.";
                }
            } else {
                $showError = "Mật khẩu không trùng khớp.";
            }
        } else {
            $exists = "Tên đăng nhập hoặc email đã tồn tại.";
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Signup</title>
</head>
<body>
    <?php
    if ($showAlert) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            Tài khoản đã được tạo thành công bạn có thể <a href="login.php">Đăng nhập</a> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button> 
        </div> ';
    }

    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
            <strong>Lỗi!</strong> ' . $showError . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span> 
            </button> 
        </div> ';
    }

    if ($exists) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong> ' . $exists . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button>
        </div> ';
    }
    ?>
    <div class="container my-5">
        <h2 class="text-center">Đăng kí ngay</h2>
        <form action="" method="post">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" class="form-control form-control-2" id="username" name="username" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="col2" for="customer_name">Họ và tên</label>
                    <input type="text" class="form-control" name="customer_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label  for="password">Mật khẩu</label>
                    <input type="password" class="form-control form-control-2" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="col2" for="cpassword">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control " id="cpassword" name="cpassword" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="customer_email">Email</label>
                    <input type="email" class="form-control form-control-2" name="customer_email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="col2" for="customer_contact">Số điện thoại</label>
                    <input type="number" class="form-control " name="customer_contact" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="customer_address">Địa chỉ</label>
                <textarea class="form-control " name="customer_address" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
        </form>
    </div>
    <?php include('partials-front/footer.php'); ?>

<style>
    /* General Reset */
body {
    background-color: #f8f9fa;
}

/* Navbar Styling */
.navbar {
    background-color: #58B747;
    color: #ffffff;
}

.logo img {
    max-height: 50px;
}

/* Form Section */
.container {
    max-width: 900px;
}

/* Signup Form Section */
.form-control {
    border: 1px solid #58B747;
    border-radius: 5px;
    box-shadow: none;
}

.form-control:focus {
    border-color: #45A039;
    box-shadow: 0 0 5px rgba(88, 183, 71, 0.5);
}

.btn-primary {
    background-color: #58B747;
    border-color: #58B747;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #45A039;
    border-color: #45A039;
}

/* Success and Error Alert */
.alert-success {
    background-color: #d4edda;
    border-color: #58B747;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #58B747;
    color: #721c24;
}

/* Text and Margins */
h2.text-center {
    color: #58B747;
    font-weight: bold;
}
.form-control-2{
    position: relative;
    right:50px;
}
.col2{
    position: relative;
    left:60px;
}
/* Responsive Design */
@media (max-width: 768px) {
    .form-row .col-md-6 {
        margin-bottom: 15px;
    }
}

</style>
</body>

</html>


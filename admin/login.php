<?php
include('../config/constants.php');
?>
<html>
<head>
    <title>Đăng nhập - Hệ thống </title>
</head>
<body>
    <h1>Login</h1>
    <?php
    if (isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    if (isset($_SESSION['no-login-message'])) {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
    ?>
    <br><br>
    <div>
        <form action="" method="POST">
            Username: <br>
            <input type="text" name="username" placeholder="Username"> <br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Password"> <br><br>
            <input type="submit" name="submit" value="Login">
            <br>
            <br>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM tbl_admin where username='$username' and password='$password'";

    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $_SESSION['login'] = "<div class='success'>Đăng nhập thành công</div>";
        $_SESSION['user'] = $username;
        header("location:" . SITEURL . 'admin/');
    } else {
        $_SESSION['login'] = "<div class='error'>Đăng nhập thất bại</div>";
        header("location:" . SITEURL . 'admin/login.php');
    }
}
?>
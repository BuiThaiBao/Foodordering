<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food order</title>

    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="asset/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
</head>

<body>
    <script src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar Section Starts Here -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a href="http://localhost/Doanweb/index.php" class="navbar-brand">
                <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive" width="50px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form action="<?php echo SITEURL; ?>food_search.php" class="d-flex" role="search" method="POST">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo SITEURL; ?>">Trang chủ</a>
                    </li>
                    <?php if (empty($_SESSION["u_id"])): ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                    <?php else:
                        $u_id = $_SESSION["u_id"];
                    ?>

                        <li class="nav-item">
                            <a href="view_cart.php" class="nav-link">Giỏ Hàng</a>
                        </li>
                        <li class="nav-item">
                            <a href="myorders.php" class="nav-link">Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo SITEURL; ?>user_profile.php?u_id=<?php echo $u_id ?>" class="nav-link">Profile</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


</body>

</html>
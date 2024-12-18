<?php
include('config/constants.php');
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}
header("Location: view_cart.php");
exit();

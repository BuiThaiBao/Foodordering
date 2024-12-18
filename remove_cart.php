<?php
include('config/constants.php');

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    if (isset($_SESSION['cart'][$food_id])) {
        unset($_SESSION['cart'][$food_id]);
    }
    header("Location: view_cart.php");
    exit();
} else {
    header("Location: view_cart.php");
    exit();
}

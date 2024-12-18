<?php
include('partials-front/menu.php');
if (!isset($_SESSION['u_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    header('Location: ' . SITEURL . 'login.php');
    exit;
}
if (isset($_POST['food_id']) && isset($_POST['quantity'])) {
    $food_id = $_POST['food_id'];
    $quantity = intval($_POST['quantity']); 
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$food_id])) {
        $_SESSION['cart'][$food_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$food_id] = array('quantity' => $quantity);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>

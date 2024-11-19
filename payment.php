<?php
if (!isset($_SESSION['u_id'])) {
    // Redirect to the login page if the user is not logged in
    header("login.php");
    exit;
}

<?php
if (strpos($_SERVER['SCRIPT_NAME'], 'admin') !== false) {
    session_name('admin_session'); 
} else {
    session_name('user_session'); 
}
session_start();
define('SITEURL', 'http://localhost/Doanweb/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'doanweb');
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); 

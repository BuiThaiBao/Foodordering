<?php
include 'config/constants.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['u_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $sender = 'user'; 
    $sql = "INSERT INTO chat_messages (user_id, message, sender) VALUES ('$user_id', '$message', '$sender')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
    }
    exit;
}
?>

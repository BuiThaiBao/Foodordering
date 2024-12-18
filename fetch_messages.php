<?php
include 'config/constants.php';
$user_id = $_SESSION['u_id'];
$sql = "SELECT * FROM chat_messages WHERE user_id = '$user_id' ORDER BY created_at ASC";
$result = mysqli_query($conn, $sql);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>

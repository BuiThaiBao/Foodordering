<?php
include 'config/constants.php'; 
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
    $user_id = $_SESSION['u_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Review_Name_" . rand(0000, 9999) . '.' . $ext;
        $src = $_FILES['image']['tmp_name'];
        $dst = "./images/reviews/" . $image_name;
        $upload = move_uploaded_file($src, $dst);
        if ($upload == false) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            header('location:' . SITEURL . "food_detail_show.php");
            exit();
        }
    } else {
        $image_name = ""; 
    }
    $sql = "INSERT INTO tbl_review (f_id, u_id, comment, rating, create_at, image_name) 
            VALUES ('$food_id', '$user_id', '$comment', '$rating',Now(), '$image_name')";
    $res = mysqli_query($conn, $sql);

    if ($res === true) {
        header("Location: food_detail_show.php?food_id=$food_id");
        exit();
    } else {
        echo "Lỗi khi thêm đánh giá: " . mysqli_error($conn);
    }
}

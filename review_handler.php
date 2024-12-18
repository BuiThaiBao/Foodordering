<?php
include 'config/constants.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape input - nhưng không cần dùng mysqli_real_escape_string nếu dùng Prepared Statements
    $food_id = $_POST['food_id'];
    $user_id = $_SESSION['u_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Upload ảnh nếu người dùng có chọn file
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Review_Name_" . rand(0000, 9999) . '.' . $ext;
        $src = $_FILES['image']['tmp_name'];
        $dst = "./images/reviews/" . $image_name;

        // Di chuyển ảnh đến thư mục đích
        if (!move_uploaded_file($src, $dst)) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            header('Location: ' . SITEURL . "food_detail_show.php");
            exit();
        }
    } else {
        $image_name = "";
    }
    $stmt = $conn->prepare("INSERT INTO tbl_review (f_id, u_id, comment, rating, create_at, image_name) VALUES (?, ?, ?, ?, NOW(), ?)");

    if ($stmt === false) {
        die("Failed to prepare the statement: " . $conn->error);
    }

    // Bind dữ liệu với Prepared Statement
    $stmt->bind_param("iisss", $food_id, $user_id, $comment, $rating, $image_name);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        header("Location: food_detail_show.php?food_id=$food_id");
        exit();
    } else {
        echo "Lỗi khi thêm đánh giá: " . $stmt->error;
    }

    $stmt->close();
}
?>

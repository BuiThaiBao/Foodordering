<?php ob_start();
include('partials/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
   
</head>
<body>

<div class="main-content">
    <h1>Update User</h1>
    <br><br>

    <?php
    // Kiểm tra ID hợp lệ
    if (!isset($_GET['id'])) {
        header('location:' . SITEURL . 'admin/manage-users.php');
        exit;
    }

    $id = $_GET['id'];

    // Lấy thông tin người dùng từ Cơ sở dữ liệu với Prepared Statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $full_name = $row['customer_name'];
        $username = $row['username'];
        $customer_email = $row['customer_email'];
        $customer_contact = $row['customer_contact'];
        $customer_address = $row['customer_address'];
    } else {
        header('location:' . SITEURL . 'admin/manage-users.php');
        exit;
    }
    ?>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Họ và tên: </td>
                <td><input type="text" name="customer_name" value="<?php echo htmlspecialchars($full_name); ?>"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>"></td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td><input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact); ?>"></td>
            </tr>
            <tr>
                <td>Address: </td>
                <td><input type="text" name="customer_address" value="<?php echo htmlspecialchars($customer_address); ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="submit" name="submit" value="Update User" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
// Xử lý form submit
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['customer_name'];
    $username = $_POST['username'];
    $customer_email = $_POST['customer_email'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    // Prepared Statement để ngăn SQL Injection
    $stmt = $conn->prepare("UPDATE users SET 
                                customer_name = ?, 
                                username = ?, 
                                customer_email = ?, 
                                customer_contact = ?, 
                                customer_address = ?
                                WHERE id = ?");

    $stmt->bind_param("sssssi", $full_name, $username, $customer_email, $customer_contact, $customer_address, $id);

    if ($stmt->execute()) {
        $_SESSION['update'] = "<div class='success'>Cập nhật thành viên thành công</div>";
        header('location:' . SITEURL . 'admin/manage-user.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Có lỗi trong quá trình cập nhật thông tin thành viên</div>";
        header('location:' . SITEURL . 'admin/manage_update.php');
    }
}
?>

<?php include('partials/footer.php'); ?>
</body>
<style>
        /* General Styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Main content styling */
        .main-content {
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 30px;
            margin-bottom: 20px;
        }
    </style>
</html>

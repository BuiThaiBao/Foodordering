<?php
ob_start();
include('partials/header.php');
?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Sửa đổi thông tin nhân viên</h1>
    </div>
    <br><br>

    <?php
    $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
        $username = $row['username'];
        $email = $row['email'];
        $address = $row['address'];
        $contact = $row['contact'];
        $level = $row['level'];
    } else {
        header('location: ' . SITEURL . 'admin/manage_admin.php');
        exit();
    }
    ?>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>"></td>
            </tr>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"></td>
            </tr>
            <tr>
                <td>Địa chỉ: </td>
                <td><input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"></td>
            </tr>
            <tr>
                <td>Số điện thoại: </td>
                <td><input type="text" name="contact" value="<?php echo htmlspecialchars($contact); ?>"></td>
            </tr>
            <tr>
                <td>Level:</td>
                <td><input type="number" name="level" value="<?php echo htmlspecialchars($level); ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $level = $_POST['level'];
        $stmt = $conn->prepare("UPDATE tbl_admin SET 
            full_name = ?, 
            username = ?, 
            email = ?, 
            address = ?, 
            contact = ?, 
            level = ?
            WHERE id = ?");
        $stmt->bind_param("ssssssi", $full_name, $username, $email, $address, $contact, $level, $id);

        if ($stmt->execute()) {
            $_SESSION['update'] = "<div class='success'>Thay đổi thông tin thành công</div>";
            header('location: ' . SITEURL . 'admin/manage_admin.php');
            exit();
        } else {
            $_SESSION['update'] = "<div class='error'>Thay đổi thông tin thất bại</div>";
            header('location: ' . SITEURL . 'admin/update_admin.php?id=' . $id);
            exit();
        }
    }
    ?>

</div>

<?php
include('partials/footer.php');
?>
<style>
    /* General Page Layout */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .main-content {
        background-color: #ffffff;
        padding: 20px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    h1 {
        font-size: 28px;
        color: #343a40;
        text-align: center;
    }

    /* Table Styling */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    table tr td {
        padding: 10px;
        font-size: 16px;
    }

    table input {
        padding: 8px;
        width: 100%;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Buttons */
    input[type="submit"] {
        background-color: #17a2b8;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #117a8b;
    }

    /* Alerts */
    .success {
        color: #155724;
        background-color: #d4edda;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
</style>

<?php
ob_start();
include('partials-front/menu.php');
?>
<div>
    <div>
        <h1>Cập nhật người dùng</h1>
        <br>
        <br>

        <?php
        if (isset($_GET['u_id'])) {
            $u_id = $_GET['u_id'];
            $sql = "Select * from users where id = $u_id";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);

            $customer_name = $row["customer_name"];
            $customer_email = $row["customer_email"];
            $old_customer_image = $row["customer_image"];
            $customer_contact = $row["customer_contact"];
            $customer_address = $row["customer_address"];
        } else {


            header('location:' . SITEURL . 'user_profile.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                <tr>
                    <td>Tên người dùng:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                <td>Số điện thoại:</td>
                <td><input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                <td>Địa chỉ</td>
                <td><input type="text" name="customer_address" value="<?php echo $customer_address; ?>">
                    </td>
                </tr>
                <td>Ảnh đại diện: </td>
                <td>
                <img src="<?php echo SITEURL; ?>images/user/<?php echo $old_customer_image ?>" width="100px">
                </td>
                </tr>
                <tr>
                    <td>Thay ảnh đại diện:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="old_customer_image" value="<?php echo $old_customer_image; ?>">
                        <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
                        <input type="submit" name="submit" value="Cập nhật thông tin" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($_POST["submit"])){
            $u_id = $_POST["u_id"];
            $customer_name = $_POST['customer_name'];
            $customer_email = $_POST['customer_email'];
            $customer_contact = $_POST['customer_contact'];
            $customer_address = $_POST['customer_address'];
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];
                if($image_name != ""){
                    $ext = end(explode('.', $image_name));
                    $image_name = "User_" . rand(0000, 9999) . '.' . $ext;

                    $src_path = $_FILES['image']['tmp_name'];

                    $dest_path = "images/user/" . $image_name;

                    $upload = move_uploaded_file($src_path, $dest_path);    
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";    
                        header('location' . SITEURL . "user_profile.php?u_id=".$u_id);
                        die();
                    }
                }else{
                    $image_name = $old_customer_image;
                }
            }else{
                $image_name = $old_customer_image;
            }
            $sql2 = "UPDATE users SET
            customer_name = '$customer_name',
            customer_email = '$customer_email',
            customer_contact = '$customer_contact',
            customer_address = '$customer_address',
            customer_image = '$image_name'
            WHERE id = $u_id
            ";
            $res2 = mysqli_query($conn, $sql2);
            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Cập nhật thành công</div>";
                header('location:' . SITEURL . 'user_profile.php?u_id='.$u_id);
            } else {
                $_SESSION['update'] = "<div class='error'>Cập nhât thất bại</div>";
                header('location:' . SITEURL . 'user_profile.php?u_id='.$u_id);
            }
            
        }
        ?>
       

    </div>
</div>
<style>
    /* Reset some default browser styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* General body styles */
body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f9f9f9;
    color: #333;
}

/* Container styles */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px 0;
}

/* Header section */
h1 {
    text-align: center;
    color: #58B747;
    margin-bottom: 20px;
}

/* Form styles */


/* Form table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

td {
    padding: 10px;
  
}

/* Input styles */
input[type="text"],
input[type="file"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
    position:relative;
    right:400px
}

input[type="text"]:focus,
input[type="file"]:focus {
    border-color: #58B747;
}

/* Button styles */
.btn-primary {
    background-color: #58B747;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #45a030;
}

/* Success & Error messages */
.success {
    color: #28a745;
    text-align: center;
    margin: 10px 0;
}

.error {
    color: #dc3545;
    text-align: center;
    margin: 10px 0;
}

/* Image display styles */
img {
    border-radius: 4px;
    margin: 10px 0;
    position:relative;
    right:400px
}

/* Responsive design */
@media screen and (max-width: 768px) {
    table td,
    input[type="text"],
    input[type="file"] {
        width: 100%;
    }

    .btn-primary {
        width: 100%;
    }
}

</style>
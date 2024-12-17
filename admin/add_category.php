<?php include('partials/header.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Thêm danh mục</h1>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên danh mục: </td>
                    <td><input type="text" name="title" placeholder="Tên danh mục" required></td>
                </tr>
                <tr>
                    <td>Tải ảnh lên: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Có
                        <input type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Có
                        <input type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm Danh Mục">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = htmlspecialchars($_POST['title']);
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            $image_name = "";
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_types)) {
                    $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination = "../images/category/" . $image_name;

                    if (!move_uploaded_file($source_path, $destination)) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        header('location:' . SITEURL . "admin/add_category.php");
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Định dạng ảnh không hợp lệ</div>";
                    header('location:' . SITEURL . "admin/add_category.php");
                    die();
                }
            }

            $sql = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $title, $image_name, $featured, $active);

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['add'] = "<div class='success'>Thêm danh mục thành công</div>";
                    header('location:' . SITEURL . 'admin/manage_category.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Lỗi thêm danh mục</div>";
                    header('location:' . SITEURL . 'admin/add_category.php');
                }
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['add'] = "<div class='error'>Lỗi chuẩn bị câu lệnh SQL</div>";
                header('location:' . SITEURL . 'admin/add_category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

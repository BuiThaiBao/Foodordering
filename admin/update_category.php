<?php
include('partials/header.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Cập nhật danh mục</h1><br>
        <br>


        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id = '$id'";

            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $old_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                $_SESSION['no_category_found'] = "<div class='error'>Không tìm thấy danh mục</div>";
                header('location: admin/manage_category.php');
            }
        } else {
            header('location: admin/manage_category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên danh mục:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>
                <tr>
                    <td>Hình ảnh:</td>
                    <td>
                        <?php
                        if ($old_image != "") {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $old_image ?>" width="150px">
                        <?php

                        } else {

                            echo "<div class='error'>Không có hình ảnh</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Hình ảnh mới</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Có
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Có
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="old_image" value="<?php echo $old_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $old_image = $_POST['old_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];


            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    $ext = end(explode('.', $image_name));

                    $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination = "../images/category/" . $image_name;
                    $upload = move_uploaded_file($source_path, $destination);
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Tải lên thất bại</div>";
                        header('location' . SITEURL . "admin/add_category.php");
                        die();
                    }

                    if ($old_image != "") {

                        $remove_path = "../images/category/" . $old_image;
                        $remove = unlink($remove_path);
                        if ($remove == false) {
                            $_SESSION['fail_remove'] = "<div class='error'>Xóa ảnh thất bại</div>";

                            header('location:' . SITEURL . "admin/manage_category.php");

                            die();
                        }
                    }
                } else {
                    $image_name = $old_image;
                }
            } else {
                $image_name = $old_image;
            }
            $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Cập nhật danh mục thành công</div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Cập nhật thất bại </div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            }
        }
        ?>
    </div>
</div>
<?php
include('partials/footer.php');
?>
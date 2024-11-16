<?php
include('partials/header.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Cập nhật món ăn</h1>



        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($res2);
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $old_image = $row2['image_name'];
            $old_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        } else {
            header('location:' . SITEURL . 'admin/manage_food.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Tên món ăn: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Miêu tả:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Giá bán: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Hình ảnh:</td>
                    <td>
                        <?php
                        if ($old_image != "") {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/foods/<?php echo $old_image ?>" width="100px">
                        <?php

                        } else {

                            echo "<div class='error'>Không có ảnh</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Ảnh mới:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Danh mục </td>
                    <td>
                        <select name="category">

                            <?php
                            $sql = "SELECT * FROM tbl_category where active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                            ?>
                                    <option <?php if ($old_category == $category_id) {
                                                echo "selected";
                                            } ?>value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                            <?php

                                }
                            } else {
                                echo "<option value='0'>Category not available</option>";
                            }



                            ?>

                        </select>
                    </td>

                </tr>
                <tr>
                    <td>Nổi bật</td>
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
                    <td>Trạng thái: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Có
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="old_image" value="<?php echo $old_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $id = $_POST["id"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $old_image = $_POST["old_image"];
            $category = $_POST["category"];
            $featured = $_POST["featured"];
            $active = $_POST["active"];



            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    $ext = end(explode('.', $image_name));
                    $image_name = "Food_" . rand(0000, 9999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination = "../images/foods/" . $image_name;
                    $upload = move_uploaded_file($source_path, $destination);
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        header('location' . SITEURL . "admin/add_food.php");

                        die();
                    }

                    if ($old_image != "") {

                        $remove_path = "../images/foods/" . $old_image;
                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            $_SESSION['fail_remove'] = "<div class='error'>Lỗi xóa ảnh</div>";
                            header('location:' . SITEURL . "admin/manage_food.php");
                            die();
                        }
                    }
                } else {
                    $image_name = $old_image;
                }
            } else {
                $image_name = $old_image;
            }
            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";
            $res3 = mysqli_query($conn, $sql3);
            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Cập nhật món ăn thành công</div>";
                header('location:' . SITEURL . 'admin/manage_food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Lỗi cập nhật</div>";
                header('location:' . SITEURL . 'admin/manage_food.php');
            }
        }
        ?>
    </div>
</div>
<?php
include('partials/footer.php');
?>
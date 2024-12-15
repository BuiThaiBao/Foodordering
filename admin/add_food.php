<?php
ob_start();
include('partials/header.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên món:</td>
                    <td>
                        <input type="text" name="title" placeholder="Tên món" required>
                    </td>
                </tr>
                <tr>
                    <td>Miêu tả:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Miêu tả món ăn"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Giá bán:</td>
                    <td>
                        <input type="number" name="price" required>
                    </td>
                </tr>
                <tr>
                    <td>Chọn ảnh:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Danh mục:</td>
                    <td>
                        <select name="category" required>
                            <?php
                            // Fetch categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                                }
                            } else {
                                echo "<option value='0'>Không có danh mục</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Có
                        <input type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Có
                        <input type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm món">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Sanitize inputs
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $category = intval($_POST['category']);
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            $image_name = "";

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];

                // Validate image file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_types)) {
                    $image_name = "Food_" . rand(0000, 9999) . '.' . $ext;
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/food/" . $image_name;

                    if (!move_uploaded_file($src, $dst)) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        header('location:' . SITEURL . "admin/add_food.php");
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Định dạng ảnh không hợp lệ</div>";
                    header('location:' . SITEURL . "admin/add_food.php");
                    die();
                }
            }

            // Insert into database
            $sql2 = "INSERT INTO tbl_food SET
                        title = ?,
                        description = ?,
                        price = ?,
                        image_name = ?,
                        category_id = ?,
                        featured = ?,
                        active = ?";

            if ($stmt = mysqli_prepare($conn, $sql2)) {
                mysqli_stmt_bind_param($stmt, "ssdsiss", $title, $description, $price, $image_name, $category, $featured, $active);
                $res2 = mysqli_stmt_execute($stmt);

                if ($res2) {
                    $_SESSION['add'] = "<div class='success'>Thêm món thành công</div>";
                    header('location:' . SITEURL . 'admin/manage_food.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Thêm món thất bại</div>";
                    header('location:' . SITEURL . 'admin/add_food.php');
                }

                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['add'] = "<div class='error'>Lỗi chuẩn bị truy vấn</div>";
                header('location:' . SITEURL . 'admin/add_food.php');
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>

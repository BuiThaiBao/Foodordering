<?php
ob_start();
include('partials/header.php');
?>

<style>
/* General Styling for the page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.main-content {
    width: 70%;
    margin: 30px auto;
    padding: 20px;
}

/* Additional CSS left unchanged */
</style>

<div class="main-content">
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Use Prepared Statement to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM tbl_category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $old_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            $_SESSION['no_category_found'] = "<div class='error'>Không tìm thấy danh mục</div>";
            header('location: admin/manage_category.php');
            exit();
        }
    } else {
        header('location: admin/manage_category.php');
        exit();
    }
    ?>

    <div class="bottom-wrapper">
        <h1>Cập nhật danh mục</h1><br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên danh mục:</td>
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required></td>
                </tr>
                <tr>
                    <td>Hình ảnh:</td>
                    <td>
                        <?php
                        if ($old_image != "") {
                            echo "<img src='" . SITEURL . "images/category/" . htmlspecialchars($old_image) . "' width='150px'>";
                        } else {
                            echo "<div class='error'>Không có hình ảnh</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Hình ảnh mới:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td class="radio-group">
                        <input <?php echo $featured == "Yes" ? "checked" : ""; ?> type="radio" name="featured" value="Yes"> Có
                        <input <?php echo $featured == "No" ? "checked" : ""; ?> type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td class="radio-group">
                        <input <?php echo $active == "Yes" ? "checked" : ""; ?> type="radio" name="active" value="Yes"> Có
                        <input <?php echo $active == "No" ? "checked" : ""; ?> type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($old_image); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="submit" name="submit" value="Cập nhật danh mục">
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
            $image_name = $old_image;
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination = "../images/category/" . $image_name;

                if (!move_uploaded_file($source_path, $destination)) {
                    $_SESSION['upload'] = "<div class='error'>Tải lên thất bại</div>";
                    header('location: ' . SITEURL . "admin/manage_category.php");
                    exit();
                }
                if ($old_image && file_exists("../images/category/" . $old_image)) {
                    unlink("../images/category/" . $old_image);
                }
            }
            $stmt = $conn->prepare("UPDATE tbl_category SET title = ?, image_name = ?, featured = ?, active = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $title, $image_name, $featured, $active, $id);

            if ($stmt->execute()) {
                $_SESSION['update'] = "<div class='success'>Cập nhật danh mục thành công</div>";
                header('location: ' . SITEURL . 'admin/manage_category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Cập nhật thất bại</div>";
                header('location: ' . SITEURL . 'admin/manage_category.php');
            }
            exit();
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>

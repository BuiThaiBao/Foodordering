<?php include('partials/header.php')
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Thêm danh mục</h1>
        <br>
        <br>
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
                    <td>
                        <input type="text" name="title" placeholder="Tên danh mục">
                    </td>
                </tr>
                <tr>
                    <td>Tải ảnh lên: </td>
                    <td>
                        <input type="file" name="image">
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
            $title = $_POST['title'];
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            if (isset($_FILES['image']['name'])) {

                $image_name = $_FILES['image']['name'];


                if ($image_name != "") {


                    //Lấy đuôi ảnh 
                    $ext = end(explode('.', $image_name));


                    $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination = "../images/categories/" . $image_name;


                    $upload = move_uploaded_file($source_path, $destination);


                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";

                        header('location:' . SITEURL . "admin/add_category.php");

                        die();
                    }
                }
            } else {
                $image_name = "";
            }
            $sql = "INSERT INTO tbl_category SET 
            title='$title', 
            image_name='$image_name',
            featured='$featured', 
            active='$active'
            ";
            $res = mysqli_query($conn, $sql);


            if ($res == true) {

                $_SESSION['add'] = "<div class='success'>Thêm danh mục thành công </div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            } else {

                $_SESSION['add'] = "<div class='error'>Lỗi thêm danh mục</div>";
                header('location:' . SITEURL . 'admin/add_category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php')

?>
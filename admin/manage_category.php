<?php
include("partials/header.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Quản lý danh mục </h1>

        <br /> <br />
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['fail_remove'])) {
            echo $_SESSION['fail_remove'];
            unset($_SESSION['fail_remove']);
        }
        if (isset($_SESSION['no_category_found'])) {
            echo $_SESSION['no_category_found'];
            unset($_SESSION['no_category_found']);
        }

        ?>
        <br><br>
        <a href="<?php echo SITEURL; ?>admin/add_category.php">Thêm danh mục</a>

        <br /> <br /> <br />
        <table border=1>
            <tr>
                <th>Stt</th>
                <th>Tên danh mục</th>
                <th>Image</th>
                <th>Nổi bật</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>

            <?php

            $sql = "SELECT * FROM tbl_category ";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $stt = 1;


            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>
                    <tr>
                        <td><?php echo $stt++ ?></td>
                        <td><?php echo $title; ?></td>

                        <td>
                            <?php

                            if ($image_name != "") {
                            ?>

                                <img src="<?php echo SITEURL; ?>images/categories/<?php echo $image_name; ?>" width=150px>

                            <?php
                            } else {
                                echo "<div class='error'>Chưa có ảnh</div>";
                            }

                            ?>
                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update_category.php?id=<?php echo $id; ?>">Cập nhật</a>
                            <a href="<?php echo SITEURL; ?>admin/delete_category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" onclick="return confirmDelete();">Xóa</a>
                        </td>
                    </tr>
                <?php

                }
            } else {

                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">Chưa có danh mục </div>
                    </td>
                </tr>
            <?php
            }



            ?>





        </table>
    </div>

</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa danh mục này không?");
    }
</script>

<?php
include("partials/footer.php");
?>
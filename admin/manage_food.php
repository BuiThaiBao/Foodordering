<?php
include("partials/header.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Quản lý món ăn</h1>
        <br>
        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['fail_remove'])) {
            echo $_SESSION['fail_remove'];
            unset($_SESSION['fail_remove']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <a href="<?php echo SITEURL ?>admin/add_food.php">Thêm món ăn</a>
    </div>
    <br><br><br>
    <table border=1>
        <tr>
            <th>STT</th>
            <th>Tên món ăn</th>
            <th>Miêu tả</th>
            <th>Giá bán</th>
            <th>Hình ảnh</th>
            <th>Nổi bật</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>

        <?php
        $sql = "SELECT * FROM tbl_food";

        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $stt = 1;
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];


        ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $description; ?></td>
                    <td><?php echo $price; ?> VND</td>
                    <td>
                        <?php
                        if ($image_name == "") {
                            echo "<div  class='error'>Không có ảnh</div";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/foods/<?php echo $image_name; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update_food.php?id=<?php echo $id; ?>">Cập nhật</a>
                        <a href="<?php echo SITEURL; ?>admin/delete_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" onclick="return confirmDelete();">Xóa</a>
                    </td>
                </tr>

        <?php
            }
        } else {
            echo "<tr> <td colspan='7' class='error'>Không có món ăn </td></tr>";
        }
        ?>
    </table>

    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa món ăn này không?");
        }
    </script>


</div>
<?php
include("partials/footer.php");
?>
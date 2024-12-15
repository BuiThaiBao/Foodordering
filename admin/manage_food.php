<?php
include("partials/header.php");
?>

<html>

<head>
    <style>
        /* Dropdown Lọc */
        .filter-section {
            margin-bottom: 20px;
        }
        .filter-section select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="main-content">
    <div class="wrapper">
        <h1 class="text-center">Quản lý món ăn</h1>
        <br>

        <!-- Phần lọc theo danh mục -->
        <div class="filter-section">
            <form method="GET" action="">
                <label for="category">Lọc theo danh mục:</label>
                <select name="category" id="category">
                    <option value="">Tất cả danh mục</option>
                    <?php
                    // Lấy danh sách danh mục từ Cơ sở dữ liệu
                    $category_sql = "SELECT * FROM tbl_category";
                    $category_res = mysqli_query($conn, $category_sql);

                    if ($category_res && mysqli_num_rows($category_res) > 0) {
                        while ($category_row = mysqli_fetch_assoc($category_res)) {
                            $selected = isset($_GET['category']) && $_GET['category'] == $category_row['id'] ? "selected" : "";
                            echo "<option value='" . $category_row['id'] . "' $selected>" . $category_row['title'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>

        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
            unset($_SESSION['add']);
        }
        ?>

        <a href="<?php echo SITEURL ?>admin/add_food.php" class="btn btn-primary">Thêm món ăn</a>
        <br><br>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên món ăn</th>
                    <th>Danh mục</th>
                    <th>Miêu tả</th>
                    <th>Giá bán</th>
                    <th>Hình ảnh</th>
                    <th>Nổi bật</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy danh mục lọc từ request
                $filter_category = isset($_GET['category']) ? $_GET['category'] : "";

                $sql = "
                SELECT 
                    tbl_food.id, 
                    tbl_food.title AS food_title, 
                    tbl_food.description, 
                    tbl_food.price, 
                    tbl_food.image_name, 
                    tbl_food.featured, 
                    tbl_food.active, 
                    tbl_category.title AS category_title
                FROM 
                    tbl_food
                INNER JOIN 
                    tbl_category 
                ON 
                    tbl_food.category_id = tbl_category.id
                ";

                // Thêm điều kiện lọc nếu có
                if ($filter_category) {
                    $sql .= " WHERE tbl_food.category_id = '" . mysqli_real_escape_string($conn, $filter_category) . "'";
                }

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $stt = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['food_title'];
                        $category_title = $row['category_title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $category_title ?></td>
                            <td><?php echo $description; ?></td>
                            <td><?php echo number_format($price); ?> VND</td>
                            <td>
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='text-danger'>Không có ảnh</div>";
                                } else {
                                ?>
                                    <img src="<?php echo SITEURL; ?>/images/food/<?php echo $image_name; ?>" width="100px" class="rounded">
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update_food.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                                <a href="<?php echo SITEURL; ?>admin/delete_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Xóa</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr> <td colspan='8' class='text-center text-danger'>Không có món ăn </td></tr>";
                }
                ?>
            </tbody>
        </table>

        <script>
            function confirmDelete() {
                return confirm("Bạn có chắc chắn muốn xóa món ăn này không?");
            }
        </script>
    </div>
</div>
</body>

</html>
<?php
include("partials/footer.php");
?>

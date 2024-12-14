<?php
include("partials/header.php");
?>
<html>

<head>
    <style>
        /* Page Layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .main-content {
            background-color: #ffffff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        /* Title Styling */
        h1 {
            color: #343a40;
            font-size: 28px;
        }

        /* Alerts */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        /* Buttons */
        .btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        /* Images */
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>

<body>


    <div class="main-content">
        <div class="wrapper">
            <h1 class="text-center">Quản lý món ăn</h1>
            <br>
            <?php
            if (isset($_SESSION['add'])) {
                echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
                unset($_SESSION['add']);
            }
            if (isset($_SESSION['delete'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['upload'])) {
                echo '<div class="alert alert-warning">' . $_SESSION['upload'] . '</div>';
                unset($_SESSION['upload']);
            }
            if (isset($_SESSION['fail_remove'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['fail_remove'] . '</div>';
                unset($_SESSION['fail_remove']);
            }
            if (isset($_SESSION['update'])) {
                echo '<div class="alert alert-info">' . $_SESSION['update'] . '</div>';
                unset($_SESSION['update']);
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
                       tbl_food.category_id = tbl_category.id;
                   ";

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
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px" class="rounded">
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
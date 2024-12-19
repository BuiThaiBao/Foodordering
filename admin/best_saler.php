<?php
include('partials/header.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sản phẩm bán chạy nhất</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>

    <?php
    $sql = "
    SELECT 
        f.id, 
        f.title, 
        f.price, 
        f.image_name, 
        c.title AS category_title, 
        COUNT(o.food_id) AS total
    FROM tbl_order_details o
    JOIN tbl_food f ON o.food_id = f.id
    JOIN tbl_category c ON f.category_id = c.id
    GROUP BY f.id, f.title, f.price, f.image_name, c.title
    ORDER BY total DESC
    LIMIT 3;
";



    $result = $conn->query($sql);
    ?>

    <h3>Sản phẩm bán chạy nhất:</h3>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category ID</th>
                <th>Total Sold</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>

                        <img src="<?php echo SITEURL; ?>/images/food/<?php echo $row['image_name'] ?>" width="100px" class="rounded">


                    </td>
                    <td><?= $row['category_title'] ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Không có dữ liệu.</p>
    <?php endif; ?>

    <?php
    $conn->close();
    ?>

</body>

</html>
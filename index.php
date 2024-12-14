<?php include('partials-front/menu.php'); ?>
<?php
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order</title>
    <style>
        /* General Styles */


/* Responsive adjustments (if needed) */
@media (max-width: 768px) {
    .food-menu-grid, .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}
    </style>

    <!-- Bootstrap CSS -->
</head>

<body>
    <!-- Danh mục -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Danh mục</h2>

            <div class="categories-grid">
                <?php
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 8";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                ?>
                        <div class="category-item">
                            <a href="<?php echo SITEURL; ?>category_foods.php?category_id=<?php echo $id; ?>" class="category-link">
                                <div class="category-image-wrapper">
                                    <?php if ($image_name != "") { ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="category-image">
                                    <?php } else { ?>
                                        <div class="error">Image not Available</div>
                                    <?php } ?>
                                </div>
                                <h3 class="category-title"><?php echo $title; ?></h3>
                            </a>
                        </div>

                <?php
                    }
                } else {
                    echo "<div class='error text-center'>Category not Added.</div>";
                }
                ?>
            </div>

        </div>
        <a class="link-to" style="" href="<?php echo SITEURL; ?>categories.php">Xem thêm danh mục </a>
    </section>

    <!-- Món ăn nổi bật -->
    <section class="food-menu-section">
        <div class="container">
            <h2 class="section-title">Món ăn nổi bật</h2>
            <div class="food-menu-grid">
                <?php
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 8";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                if ($count2 > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                ?>
                        <!-- Start of the link -->
                        <div class="food-item">
                        <a href="<?php echo SITEURL; ?>food_detail_show.php?food_id=<?php echo $id; ?>" class="food-item-link">
                            <div class="food-image-wrapper">
                                <?php if ($image_name != "") { ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image">
                                <?php } else { ?>
                                    <div class="error">Image not available.</div>
                                <?php } ?>
                            </div>
                            <div class="food-details">
                                <h4 class="food-title"><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?> VND</p>
                                <p class="food-description"><?php echo $description; ?></p>
                            </div>
                            </a>
                            <form action="<?php echo SITEURL; ?>carts.php?food_id=<?php echo $id; ?>" method="POST" class="add-to-cart-form">
                                    <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                    <label for="quantity-<?php echo $id; ?>">Số lượng:</label>
                                    <input type="number" name="quantity" id="quantity-<?php echo $id; ?>" value="1" min="1" class="quantity-input">
                                    <button type="submit" class="btn btn-add-to-cart">Thêm vào giỏ</button>
                                </form>
                        </div>
                        
                        
                <?php
                    }
                } else {
                    echo "<div class='error text-center'>Food not available.</div>";
                }
                ?>
            </div>
        </div>
        <a class="link-to" style="" href="<?php echo SITEURL; ?>foods.php">Xem thêm món ăn</a>
    </section>

    <!-- Bootstrap JS -->
    <script src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include('partials-front/footer.php'); ?>
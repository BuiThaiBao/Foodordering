<?php include('partials-front/menu.php'); ?>
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">Danh mục sản phẩm </h2>

        <div class="categories-grid ">
            <?php
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
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

        <div class="clearfix"></div>
    </div>
</section>
<?php include('partials-front/footer.php'); ?>
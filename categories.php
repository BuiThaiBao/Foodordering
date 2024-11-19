<?php include('partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories py-5">
    <div class="container">
        <h2 class="text-center mb-4">Explore Foods</h2>

        <div class="row">
            <?php
            // Display all the categories that are active
            // SQL Query
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count Rows
            $count = mysqli_num_rows($res);

            // Check whether categories are available or not
            if ($count > 0) {
                // Categories Available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the Values
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>

                    <!-- Category Card -->
                    <div class="col-md-4 mb-4">
                        <a href="<?php echo SITEURL; ?>category_foods.php?category_id=<?php echo $id; ?>" class="text-decoration-none">
                            <div class="card shadow-sm">
                                <?php
                                if ($image_name == "") {
                                    // Image not Available
                                    echo "<div class='error p-4 text-center'>Image not found.</div>";
                                } else {
                                    // Image Available
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" class="card-img-top" alt="<?php echo $title; ?>">
                                <?php
                                }
                                ?>

                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $title; ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>

            <?php
                }
            } else {
                // Categories Not Available
                echo "<div class='error text-center'>Category not found.</div>";
            }
            ?>
        </div>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
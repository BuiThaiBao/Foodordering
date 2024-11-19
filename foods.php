<?php include('partials-front/menu.php'); ?>

<section class="food-menu-section">
    <div class="container">
        <h2 class="section-title">Danh sách món ăn</h2>
        <?php
        if (isset($_SESSION['add_cart_success'])) {
            echo $_SESSION['add_cart_success'];
            unset($_SESSION['add_cart_success']);
        } ?>
        <div class="food-menu-grid">
            <?php
            // Pagination settings
            $limit = 12; // Number of products per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
            $offset = ($page - 1) * $limit; // Calculate offset

            // Display Foods that are Active
            $sql = "SELECT * FROM tbl_food WHERE active='Yes' LIMIT $limit OFFSET $offset";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count Rows
            $count = mysqli_num_rows($res);

            // Check whether the foods are available or not
            if ($count > 0) {
                // Foods Available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the Values
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
            ?>
                    <a href="<?php echo SITEURL; ?>food_detail_show.php?food_id=<?php echo $id; ?>" class="food-item-link"> <!-- Start of the link -->
                        <div class="food-item">
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
                                <form action="<?php echo SITEURL; ?>carts.php?food_id=<?php echo $id; ?>" method="POST" class="add-to-cart-form">
                                    <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                    <label for="quantity-<?php echo $id; ?>">Số lượng:</label>
                                    <input type="number" name="quantity" id="quantity-<?php echo $id; ?>" value="1" min="1" class="quantity-input">
                                    <button type="submit" class="btn btn-add-to-cart">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </a>
            <?php
                }
            } else {
                // Food not Available
                echo "<div class='error'>Food not found.</div>";
            }
            ?>
        </div>

        <div class="clearfix"></div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php
            // Get total number of products
            $total_sql = "SELECT COUNT(*) as total FROM tbl_food WHERE active='Yes'";
            $total_res = mysqli_query($conn, $total_sql);
            $total_row = mysqli_fetch_assoc($total_res);
            $total_products = $total_row['total'];
            $total_pages = ceil($total_products / $limit); // Calculate total pages

            // Display pagination links
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='page-number active'>$i</span> "; // Current page
                } else {
                    echo "<a href='?page=$i' class='page-number'>$i</a> "; // Other pages
                }
            }
            ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
<?php include('partials-front/menu.php'); ?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php

        //Get the Search Keyword
        // $search = $_POST['search'];
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        $limit = 12; // Number of products per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
        $offset = ($page - 1) * $limit; // Calculate offset
        //SQL Query to Get foods based on search keyword
        //$search = burger '; DROP database name;
        // "SELECT * FROM tbl_food WHERE title LIKE '%burger'%' OR description LIKE '%burger%'";
        $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%' LIMIT $limit OFFSET $offset";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Count Rows
        $count = mysqli_num_rows($res);

        //Check whether food available of not
        if ($count > 0) {
            //Food Available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the details
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
        ?>

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
            // Food not Available
            echo "<div class='error'>Food not found.</div>";
        }
        ?>
    </div>

    <div class="clearfix"></div>
    <div class="pagination">
        <?php
        // Get total number of products
        $total_sql = "SELECT COUNT(*) as total FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
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
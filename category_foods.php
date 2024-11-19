<?php include('partials-front/menu.php'); ?>

<?php
// Check whether id is passed or not
if (isset($_GET['category_id'])) {
    // Category id is set and get the id
    $category_id = $_GET['category_id'];
    // Get the Category Title Based on Category ID
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Get the value from Database
    $row = mysqli_fetch_assoc($res);
    // Get the Title
    $category_title = $row['title'];
} else {
    // Category not passed
    // Redirect to Home page
    header('location:' . SITEURL);
}
?>

<!-- Food Search Section Starts Here -->
<section class="food-search text-center py-5 bg-light">
    <div class="container">
        <h2 class="display-4">Explore Foods in <span class="text-primary">"<?php echo $category_title; ?>"</span></h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu py-5">
    <div class="container">
        <h2 class="text-center mb-4">Food Menu</h2>

        <div class="row">
            <?php
            // Create SQL Query to Get foods based on Selected Category
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // Count the Rows
            $count2 = mysqli_num_rows($res2);

            // Check whether food is available or not
            if ($count2 > 0) {
                // Food is Available
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
            ?>
                    <!-- Food Menu Item -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <?php
                            if ($image_name == "") {
                                // Image not Available
                                echo "<div class='error p-3 text-center'>Image not Available</div>";
                            } else {
                                // Image Available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="card-img-top" alt="<?php echo $title; ?>">
                            <?php
                            }
                            ?>

                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $title; ?></h5>
                                <p class="card-text"><?php echo $description; ?></p>
                                <p class="food-price text-success"><?php echo $price; ?> VND</p>
                                <div class="d-flex justify-content-center">
                                    <form action="<?php echo SITEURL; ?>carts.php?food_id=<?php echo $id; ?>" method="POST" class="mt-2">
                                        <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                        <div class="food_add_qty d-flex align-items-center">
                                            <label for="quantity" class="me-2">Quantity:</label>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-25">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2 w-100">Add to Cart</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Food not available
                echo "<div class='error text-center'>Food not Available.</div>";
            }
            ?>

        </div>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
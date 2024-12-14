<?php
include 'partials-front/menu.php';

// Get the food ID from URL
$food_id = intval($_GET['food_id']);

// Retrieve product details from the `tbl_food` table
$sql = "SELECT * FROM tbl_food WHERE id = $food_id";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count == 1) {
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];
    $title = $row['title'];
    $price = $row['price'];
    $description = $row['description'];
    $image_name = $row['image_name'];
}

// Fetch reviews from the `tbl_review` table based on `f_id`
$review_query = "SELECT tbl_review.*, users.username FROM tbl_review JOIN users ON tbl_review.u_id = users.id WHERE tbl_review.f_id = $food_id";
$review_result = mysqli_query($conn, $review_query);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    <div class="container mt-5">
        <!-- Product Details Section -->
        <div class="row food-detail">
            <div class="col-md-6">
                <div class="food-img">
                    <?php if ($image_name == ""): ?>
                        <div class='alert alert-danger'>Image not Available.</div>
                    <?php else: ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-fluid rounded">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6 food-info">
                <h1><?php echo $title; ?></h1>
                <p class="price"><?php echo $price ?> VND</p>
                <p class="description"><?php echo $description ?></p>
                <br><br><br><br>
                <form action="<?php echo SITEURL; ?>carts.php?food_id=<?php echo $id; ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                    <div class="food_add_qty">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" style="width: 60px;">
                    </div>
                    <input type="submit" class="btn btn-primary btn-add mt-2 w-30" value="Add to Cart">
                </form>
            </div>

        </div>

        <!-- Reviews Section -->
        <div class="food-reviews">
            <h2>Bình luận</h2>
            <?php
            $sql2 = "
                SELECT tbl_review.*, users.username 
                FROM tbl_review 
                JOIN users ON tbl_review.u_id = users.id 
                WHERE tbl_review.f_id = $food_id
                ORDER BY tbl_review.create_at DESC
            ";
            $res2 = mysqli_query($conn, $sql2);
            $count2 =  mysqli_num_rows($res2);

            if ($count2 > 0) {
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $username = $row2['username'];
                    $comment = $row2['comment'];
                    $rating = $row2['rating'];
                    $create_at = $row2['create_at'];
                    $image_name = $row2['image_name'];
            ?>
                    <div class="review-item">
                        <div><strong><?php echo $username; ?></strong></div>
                        <div class="rating-stars">
                            <?php
                            for ($i = 0; $i < $rating; $i++) {
                                echo "⭐";
                            }
                            ?>
                        </div>
                        <p><?php echo $comment; ?></p>
                        <p class="text-muted"><small><?php echo $create_at; ?></small></p>
                        <?php
                        if ($image_name == "") {
                            echo "";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/reviews/<?php echo $image_name; ?>" width="150px" class="img-thumbnail">
                        <?php
                        }
                        ?>

                    </div>

            <?php
                }
            } else {
                echo "<div class='alert alert-info'>Không có đánh giá.</div>";
            }
            ?>
        </div>

        <!-- Comment Form Section -->
        <div class="comment-form mt-5">
            <h2>Đánh giá</h2>
            <form action="review_handler.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="food_id" value="<?php echo $food_id; ?>" />
                <div class="form-group">
                    <textarea name="comment" id="comment" class="form-control" placeholder="Your comment here..." required></textarea>
                </div>

                <!-- Star Rating -->
                <div class="form-group">
                    <label for="rating">Rating: </label><br>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" class="star">&#9733;</label>

                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" class="star">&#9733;</label>

                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" class="star">&#9733;</label>

                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" class="star">&#9733;</label>

                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" class="star">&#9733;</label>
                </div>

                <div class="form-group">
                    <label for="image">Thêm hình ảnh: </label>
                    <input type="file" name="image" class="form-control-file">
                </div>

                <button type="submit" class="btn btn-primary">Đánh giá</button>
            </form>
        </div>


    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include 'partials-front/footer.php'; ?>
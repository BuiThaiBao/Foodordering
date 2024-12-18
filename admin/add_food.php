<?php
ob_start();
include('partials/header.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên món:</td>
                    <td>
                        <input type="text" name="title" placeholder="Tên món" required>
                    </td>
                </tr>
                <tr>
                    <td>Miêu tả:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Miêu tả món ăn"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Giá bán:</td>
                    <td>
                        <input type="number" name="price" required>
                    </td>
                </tr>
                <tr>
                    <td>Chọn ảnh:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Danh mục:</td>
                    <td>
                        <select name="category" required>
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                                }
                            } else {
                                echo "<option value='0'>Không có danh mục</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Có
                        <input type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Có
                        <input type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm món">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');
?>

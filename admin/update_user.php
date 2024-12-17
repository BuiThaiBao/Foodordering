<?php include('partials/header.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update User</h1>

        <br><br>

        <?php

        $id = $_GET['id'];


        $sql = "SELECT * FROM users WHERE id=$id";


        $res = mysqli_query($conn, $sql);


        if ($res == true) {

            $count = mysqli_num_rows($res);

            if ($count == 1) {

                $row = mysqli_fetch_assoc($res);
                $full_name = $row['customer_name'];
                $username = $row['username'];
                $customer_email = $row['customer_email'];
                $customer_contact = $row['customer_contact'];
                $customer_address = $row['customer_address'];
            } else {
                header('location:' . SITEURL . 'admin/manage-users.php');
            }
        }

        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Họ và tên: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="customer_address" value="<?php echo $customer_address; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update User" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['customer_name'];
    $username = $_POST['username'];
    $customer_email = $_POST['customer_email'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    $sql = "UPDATE users SET
        customer_name = '$full_name',
        username = '$username',customer_email = '$customer_email', customer_contact = ' $customer_contact',
        customer_address ='$customer_address'
        WHERE id='$id' ";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $_SESSION['update'] = "<div class='success'>User Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage_user.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
        header('location:' . SITEURL . 'admin/manage_update.php');
    }
}

?>


<?php include('partials/footer.php'); ?>
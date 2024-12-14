<?php include('partials/header.php'); ?>


<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Quản lý user</h1>

        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }

        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }

        ?>
        <br><br><br>


        <a href="add-users.php" class="btn-primary">Add User</a>

        <br /><br /><br />

        <table border="1">
            <tr>
                <th>Stt</th>
                <th>Họ và tên</th>
                <th>Username</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>


            <?php

            $sql = "SELECT * FROM users";

            $res = mysqli_query($conn, $sql);


            if ($res == TRUE) {

                $count = mysqli_num_rows($res);

                $stt = 1;

                //CHeck the num of rows
                if ($count > 0) {
                    //WE HAve data in database
                    while ($rows = mysqli_fetch_assoc($res)) {


                        //Get individual DAta
                        $id = $rows['id'];
                        $full_name = $rows['customer_name'];
                        $username = $rows['username'];
                        $email = $rows['customer_email'];
                        $contact = $rows['customer_contact'];
                        $address = $rows['customer_address'];
                        $created = $rows['created_at'];
                        //Display the Values in our Table
            ?>

                        <tr>
                            <td><?php echo $stt++; ?>. </td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $created; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update_user.php?id=<?php echo $id; ?>">Update</a>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/delete_user.php?id=<?php echo $id; ?>">Delete</a>

                            </td>
                        </tr>

            <?php

                    }
                } else {
                }
            }

            ?>



        </table>

    </div>
</div>


<?php include('partials/footer.php'); ?>
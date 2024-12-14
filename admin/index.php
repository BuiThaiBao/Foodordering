<?php
include('partials/header.php');
?>
<html>

<head>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .main-content {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 1200px;
        }

        .wrapper {
            margin: auto;
            padding: 10px;
        }

        /* Dashboard Header */
        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }

        /* Stats Grid */
        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .stat-box {
            flex: 1 1 calc(25% - 20px);
            /* Four columns layout with spacing */
            background-color: #17a2b8;
            /* Bootstrap Info Color */
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-box h1 {
            font-size: 36px;
            margin: 0;
        }

        .stat-box p {
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stat-box {
                flex: 1 1 100%;
                /* Full width on smaller screens */
            }
        }

        .alert {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .text-center {
            text-align: center;
        }

        p {
            color: white;
        }
    </style>
</head>

<body>


    <div class="main-content">
        <div class="wrapper">
            <h1 class="text-center">Dashboard</h1>
            <br>
            <br>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<div class="alert alert-success">' . $_SESSION['login'] . '</div>';
                unset($_SESSION['login']);
            }
            ?>
            <div class="row dashboard-stats">
                <div class="col-4 text-center stat-box">
                    <a href="manage_category.php">
                        <?php
                        $sql = "select * from tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        ?>
                        <h1><?php echo $count ?></h1>
                        <p>Categories</p>
                    </a>
                </div>
                <div class="col-4 text-center stat-box">
                    <a href="manage_food.php">
                        <?php
                        $sql2 = "select * from tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        $count2 = mysqli_num_rows($res2);
                        ?>
                        <h1><?php echo $count2 ?></h1>
                        <p>Food</p>
                    </a>
                </div>
                <div class="col-4 text-center stat-box">
                    <a href="manage_order.php">
                        <?php
                        $sql3 = "select * from tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);
                        ?>
                        <h1><?php echo $count3 ?></h1>
                        <p>Orders</p>
                    </a>
                </div>
                <div class="col-4 text-center stat-box">
                    <?php
                    $sql4 = "select SUM(total) as Total from tbl_order";
                    $res4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_assoc($res4);
                    $total_revenue = $row4['Total'];
                    ?>
                    <h1>$<?php echo number_format($total_revenue, 2) ?></h1>
                    <p>Total Revenue</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</body>

</html>
<?php
include('partials/footer.php');
?>
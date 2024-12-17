<?php include('partials-front/menu.php'); ?>
<body>
    <?php
    $u_id = $_GET['u_id'];
    $sql = "SELECT * FROM users WHERE id = $u_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username'];
        $full_name = $row['customer_name'];
        $email = $row['customer_email'];
        $image = $row['customer_image'];
        $contact = $row['customer_contact'];
        $address = $row['customer_address'];
    }
    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
    ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <div class="container">
            <div class="main-body">

                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center" width="400"> <img
                                        src="images/user/<?php echo $image ?>" alt="Admin" class="rounded-circle"
                                        width="250">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Họ và tên </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary"><?php echo $full_name; ?></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary"> <a href="/cdn-cgi/l/email-protection"
                                            class="__cf_email__"
                                            data-cfemail="ff99968fbf958a94928a97d19e93"><?php echo $email; ?></a></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Số điện thoại</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary"><?php echo $contact; ?></div>
                                </div>
                                <hr>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Địa chỉ</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary"><?php echo $address; ?></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12"><a class="btn btn-primary" 
                                            href="edit_profile.php?u_id=<?php echo $u_id ?>">Chỉnh sửa</a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <style type="text/css">
            body {
                
                color: #1a202c;
                text-align: left;
                background-color: #e2e8f0;
            }

            .main-body {
                padding: 0;
            }

            .card {
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            }

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 0 solid rgba(0, 0, 0, .125);
                border-radius: .25rem;
            }

            .card-body {
                flex: 1 1 auto;
                min-height: 1px;
                padding: 1rem;
            }

            .gutters-sm {
                margin-right: -8px;
                margin-left: -8px;
            }

            .gutters-sm>.col,
            .gutters-sm>[class*=col-] {
                padding-right: 8px;
                padding-left: 8px;
            }

            .mb-3,
            .my-3 {
                margin-bottom: 1rem !important;
            }

            .bg-gray-300 {
                background-color: #e2e8f0;
            }

            .h-100 {
                height: 100% !important;
            }

            .shadow-none {
                box-shadow: none !important;
            
            }
            .btn {
                background-color:#58B747 !important;
                border:none
            }
        </style>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script type="text/javascript"></script>
    </div>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-F1RTS0P1CD"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-F1RTS0P1CD');
    </script>
</body>
<?php include('partials-front/footer.php'); ?>

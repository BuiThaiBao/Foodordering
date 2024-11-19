<?php include('partials-front/menu.php'); ?>

<!DOCTYPE html>
<html
    lang="en">

<head
    itemscope="" itemtype="http://schema.org/WebSite">
    <meta
        http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title
        itemprop="name">Preview bootstrap html snippet. profile with data and skills</title>
    <meta
        name="description" itemprop="description" content="Preview bootstrap html snippet. profile with data and skills. Copy and paste the html, css and js code for save time, build your app faster and responsive">
    <meta
        name="keywords" content="html, css, javascript, themes, templates, code snippets, ui examples, react js, react-native, plagraounds, cards, front-end, profile, invoice, back-end, web-designers, web-developers">
    <link
        itemprop="sameAs" href="https://www.facebook.com/bootdey">
    <link
        itemprop="sameAs" href="https://x.com/bootdey">
    <meta
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta
        name="viewport" content="width=device-width">
    <link
        rel="shortcut icon" type="image/x-icon" href="/img/bootdey_favicon.ico">
    <link
        rel="apple-touch-icon" sizes="135x140" href="/img/bootdey_135x140.png">
    <link
        rel="apple-touch-icon" sizes="76x76" href="/img/bootdey_76x76.png">
    <link
        rel="canonical" href="https://www.bootdey.com/snippets/view/profile-with-data-and-skills" itemprop="url">
    <meta
        property="x:account_id" content="2433978487" />
    <meta
        name="x:card" content="summary">
    <meta
        name="x:card" content="summary_large_image">
    <meta
        name="x:site" content="@bootdey">
    <meta
        name="x:creator" content="@bootdey">
    <meta
        name="x:title" content="Preview bootstrap html snippet. profile with data and skills">
    <meta
        name="x:description" content="Preview bootstrap html snippet. profile with data and skills. Copy and paste the html, css and js code for save time, build your app faster and responsive">
    <meta
        name="x:image" content="https://www.bootdey.com/files/SnippetsImages/bootstrap-snippets-1105.png">
    <meta
        name="x:url" content="https://www.bootdey.com/snippets/preview/profile-with-data-and-skills">
    <meta
        property="og:title" content="Preview bootstrap html snippet. profile with data and skills">
    <meta
        property="og:url" content="https://www.bootdey.com/snippets/preview/profile-with-data-and-skills">
    <meta
        property="og:image" content="https://www.bootdey.com/files/SnippetsImages/bootstrap-snippets-1105.png">
    <meta
        property="og:description" content="Preview bootstrap html snippet. profile with data and skills. Copy and paste the html, css and js code for save time, build your app faster and responsive">
    <meta
        name="msvalidate.01" content="23285BE3183727A550D31CAE95A790AB" />
    <script src="/cache-js/cache-1635427806-97135bbb13d92c11d6b2a92f6a36685a.js" type="text/javascript"></script>
</head>

<body>
    <?php
    $u_id = $_SESSION['u_id'];
    $sql = "SELECT * FROM users WHERE id = $u_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username'];
        $full_name = $row['customer_name'];
        $email = $row['customer_email'];
        $contact = $row['customer_contact'];
        $address = $row['customer_address'];
    }
    ?>
    <div
        id="snippetContent">
        <link
            rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <div
            class="container">
            <div
                class="main-body">

                <div
                    class="row gutters-sm">
                    <div
                        class="col-md-4 mb-3">
                        <div
                            class="card">
                            <div
                                class="card-body">
                                <div
                                    class="d-flex flex-column align-items-center text-center"> <img
                                        src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                    <div
                                        class="mt-3">
                                        <h4><?php echo $username; ?></h4>
                                        <p

                                            class="btn btn-outline-primary">Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div
                        class="col-md-8">
                        <div
                            class="card mb-3">
                            <div
                                class="card-body">
                                <div
                                    class="row">
                                    <div
                                        class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div
                                        class="col-sm-9 text-secondary"><?php echo $full_name; ?></div>
                                </div>
                                <hr>
                                <div
                                    class="row">
                                    <div
                                        class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div
                                        class="col-sm-9 text-secondary"> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ff99968fbf958a94928a97d19e93"><?php echo $email; ?></a></div>
                                </div>
                                <hr>
                                <div
                                    class="row">
                                    <div
                                        class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div
                                        class="col-sm-9 text-secondary"><?php echo $contact; ?></div>
                                </div>
                                <hr>

                                <hr>
                                <div
                                    class="row">
                                    <div
                                        class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div
                                        class="col-sm-9 text-secondary"><?php echo $address; ?></div>
                                </div>
                                <hr>
                                <div
                                    class="row">
                                    <div
                                        class="col-sm-12"> <a
                                            class="btn btn-info " target="__blank" href="edit_profile.php">Edit</a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            body {
                margin-top: 20px;
                color: #1a202c;
                text-align: left;
                background-color: #e2e8f0;
            }

            .main-body {
                padding: 15px;
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

</html>
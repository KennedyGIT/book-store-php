<?php
session_start();

if (isset($_POST['logout'])) {
    // Clear all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: http://127.0.0.1:8080/bookstore_php/client/back-end/login.php');
    exit();
}

// Fetch data from the API
$url = 'http://127.0.0.1:8080/bookstore_php/api/book.api.php';
$data = array('action' => 'get_all_books');

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data)
    )
);

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

// Parse the JSON response
$books = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Fastkart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Fastkart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>Fastkart - Dashboard</title>

    <!-- Google font-->
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- Linear Icon css -->
    <link rel="stylesheet" href="../assets/css/linearicon.css">

    <!-- fontawesome css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/font-awesome.css">

    <!-- Themify icon css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">

    <!-- ratio css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/ratio.css">

    <!-- remixicon css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/remixicon.css">

    <!-- Feather icon css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/feather-icon.css">

    <!-- Plugins css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/animate.css">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">

    <!-- vector map css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vector-map.css">

    <!-- Slick Slider Css -->
    <link rel="stylesheet" href="../assets/css/vendors/slick.css">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    
    <!-- tap on top start -->
    <div class="tap-top">
        <span class="lnr lnr-chevron-up"></span>
    </div>
    <!-- tap on tap end -->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper m-0">
                <div class="header-logo-wrapper p-0">
                    <div class="logo-wrapper">
                        <a href="../dashboard/dashboard.php">
                            <img class="img-fluid main-logo" src="../assets/images/logo/1.png" alt="logo">
                            <img class="img-fluid white-logo" src="../assets/images/logo/1-white.png" alt="logo">
                        </a>
                    </div>
                    <div class="toggle-sidebar">
                        <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                        <a href="../dashboard/dashboard.php">
                            <img src="../assets/images/logo/1.png" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
                <div class="nav-right col-6 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="profile-nav onhover-dropdown pe-0 me-0">
                            <div class="media profile-media">
                            <img class="user-profile rounded-circle" src="../assets/images/users/4.jpg" alt="">
                                <div class="user-name-hide media-body">
                                <?php
                                    // Concatenate the Firstname and Lastname from session
                                    if (isset($_SESSION['Firstname']) && isset($_SESSION['Lastname'])) {
                                        $fullName = $_SESSION['Firstname'] . ' ' . $_SESSION['Lastname'];
                                        echo "<span>$fullName</span>";
                                    } else {
                                        // Redirect to the login page
                                        header('Location: http://127.0.0.1:8080/bookstore_php/client/back-end/login.php');
                                        exit();
                                    }
                                ?>
                                <p class="mb-0 font-roboto">
                                    <?php
                                    // Assuming UserType is also saved in the session
                                    if (isset($_SESSION['UserType'])) {
                                        echo $_SESSION['UserType'];
                                    } else {
                                        // Handle case where UserType is not set
                                        echo 'Role';
                                    }
                                    ?>
                                    <i class="middle ri-arrow-down-s-line"></i>
                                </p>
                                </div>
                            </div>
                            <ul class="profile-dropdown ">
                                <li class="profile-nav onhover-dropdown pe-0 me-0">
                                    <div class="media profile-media">
                                        <!-- ... (existing profile information) ... -->
                                        <ul class="profile-dropdown onhover-show-div">
                                            <li>
                                                <!-- Logout button -->
                                                <a href="#" onclick="logout()">
                                                    <i data-feather="log-out"></i>
                                                    <span>Log out</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper">
                <div id="sidebarEffect"></div>
                <div>
                    <div class="logo-wrapper logo-wrapper-center">
                        <a href="../dashboard/dashboard.php" data-bs-original-title="" title="">
                            <img class="img-fluid for-white" src="../assets/images/logo/full-white.png" alt="logo">
                        </a>
                        <div class="back-btn">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="toggle-sidebar">
                            <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                        </div>
                    </div>
                    <div class="logo-icon-wrapper">
                        <a href="../dashboard/dashboard.php">
                            <img class="img-fluid main-logo main-white" src="../assets/images/logo/logo.png" alt="logo">
                            <img class="img-fluid main-logo main-dark" src="../assets/images/logo/logo-white.png"
                                alt="logo">
                        </a>
                    </div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow">
                            <i data-feather="arrow-left"></i>
                        </div>

                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"></li>

                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav" href="../dashboard/dashboard.php">
                                        <i class="ri-home-line"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>

                                <li class="sidebar-list">
                                    <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i class="ri-store-3-line"></i>
                                        <span>Product</span>
                                    </a>
                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="../product/view-products.php">Products</a>
                                        </li>

                                        <li>
                                            <a href="../product/add-products.php">Add New Products</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i class="ri-user-3-line"></i>
                                        <span>Users</span>
                                    </a>
                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="../user/view-users.php">All Users</a>
                                        </li>
                                        <li>
                                            <a href="../user/add-user.php">Add new User</a>
                                        </li>
                                    </ul>
                                </li>

                                

                            </ul>
                        </div>

                        <div class="right-arrow" id="right-arrow">
                            <i data-feather="arrow-right"></i>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- Page Sidebar Ends-->

            <!-- index body start -->
            <div class="page-body">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table">
                                <div class="card-body">
                                    <div class="title-header option-title">
                                        <h5>Books</h5>
                                        <form class="d-inline-flex">
                                            <a href="../product/add-products.php" class="align-items-center btn btn-theme d-flex">
                                                <i data-feather="plus"></i>Add New
                                            </a>
                                        </form>
                                    </div>

                                    <div class="table-responsive table-product">
                                        <table class="table all-package theme-table" id="table_id">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Quantity</th>
                                                    <th>Genre</th>
                                                    <th>Price</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($books as $book) : ?>
                                                    <tr>
                                                        <td><?= $book['BookTitle']; ?></td>
                                                        <td><?= $book['Author']; ?></td>
                                                        <td><?= $book['AmountInStock']; ?></td>
                                                        <td><?= $book['Genre']; ?></td>
                                                        <td><?= $book['Price']; ?></td>
                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <a href="../product/edit-product.php?bookId=<?php echo $book['BookId']; ?>">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- footer start-->
                <div class="container-fluid">
                    <footer class="footer">
                        <div class="row">
                            <div class="col-md-12 footer-copyright text-center">
                                <p class="mb-0">Copyright 2023 © </p>
                            </div>
                        </div>
                    </footer>
                </div>
                <!-- footer End-->
            </div>
            <!-- index body end -->

        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    
 

    <!-- latest js -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap js -->
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- feather icon js -->
    <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>

    <!-- scrollbar simplebar js -->
    <script src="../assets/js/scrollbar/simplebar.js"></script>
    <script src="../assets/js/scrollbar/custom.js"></script>

    <!-- Sidebar jquery -->
    <script src="../assets/js/config.js"></script>

    <!-- tooltip init js -->
    <script src="../assets/js/tooltip-init.js"></script>

    <!-- Plugins JS -->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/notify/bootstrap-notify.min.js"></script>
    <script src="../assets/js/notify/index.js"></script>

    <!-- Apexchar js -->
    <script src="../assets/js/chart/apex-chart/apex-chart1.js"></script>
    <script src="../assets/js/chart/apex-chart/moment.min.js"></script>
    <script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="../assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="../assets/js/chart/apex-chart/chart-custom1.js"></script>


    <!-- slick slider js -->
    <script src="../assets/js/slick.min.js"></script>
    <script src="../assets/js/custom-slick.js"></script>

    <!-- customizer js -->
    <script src="../assets/js/customizer.js"></script>

    <!-- ratio js -->
    <script src="../assets/js/ratio.js"></script>

    <!-- sidebar effect -->
    <script src="../assets/js/sidebareffect.js"></script>

    <!-- Theme js -->
    <script src="../assets/js/script.js"></script>

    <script>
    function logout() {
        // AJAX request to trigger logout
        var xhr = new XMLHttpRequest();
        xhr.open('POST', ''); // Use appropriate URL if needed

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Redirect to the login page
                window.location.href = 'http://127.0.0.1:8080/bookstore_php/client/back-end/login.php';
            }
        };

        // Set up the data to send
        var formData = new FormData();
        formData.append('logout', 'true'); // Include the logout action

        // Send the request
        xhr.send(formData);
    }
    </script>   
</body>
</html>
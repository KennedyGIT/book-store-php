<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fastkart">
    <meta name="keywords" content="Fastkart">
    <meta name="author" content="Fastkart">
    <link rel="icon" href="../assets/images/favicon/1.png" type="image/x-icon">
    <title>Log In</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/font-awesome.css">

    <!-- feather icon css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/feather-icon.css">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick/slick-theme.css">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bulk-style.css">

    <!-- Template css -->
    <link id="color-link" rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

    <!-- log in section start -->
    <section class="log-in-section background-image-2 section-b-space">
    <?php
        session_start();
        if (isset($_POST['submit'])) {
            $requestData = [
                'action' => 'validate_user_credentials',
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];

            $apiUrl = 'http://127.0.0.1:8080/bookstore_php/api/user.api.php';

            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($requestData)
                ]
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($apiUrl, false, $context);

            if ($result === FALSE) {
                // Handle error in API call

               
                echo '<i class="fas alert alert-danger fa-bell"></i></i><strong>Error in API call</strong>';
            } else {
                $response = json_decode($result, true);

                //print_r($response);

                if (isset($response['message']) && $response['message'] === 'Valid credentials' && $response['user']['UserType'] === 'Admin') {
                    // Save attributes to session
                    $_SESSION['UserId'] = $response['user']['UserId'];
                    $_SESSION['UserType'] = $response['user']['UserType'];
                    $_SESSION['Username'] = $response['user']['Username'];
                    $_SESSION['Firstname'] = $response['user']['Firstname'];
                    $_SESSION['Lastname'] = $response['user']['Lastname'];

                    // Redirect to the admin page
                    header('Location: http://127.0.0.1:8080/bookstore_php/client/back-end/dashboard/dashboard.php');
                    exit();
                }
                else if (isset($response['message']) && $response['message'] === 'Valid credentials' && $response['user']['UserType'] === 'Regular'){
                    $_SESSION['UserId'] = $response['user']['UserId'];
                    $_SESSION['UserType'] = $response['user']['UserType'];
                    $_SESSION['Username'] = $response['user']['Username'];
                    $_SESSION['Firstname'] = $response['user']['Firstname'];
                    $_SESSION['Lastname'] = $response['user']['Lastname'];

                    header('Location: http://127.0.0.1:8080/bookstore_php/client/front-end/store.php');
                    exit();
                }
                else {
                    // Display an error message or handle invalid credentials
                    echo '<div class="alert alert-danger mt-3" role="alert">Invalid Credentials</div>';
                }
            }
        }
        ?>
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="../assets/images/inner-page/log-in.png" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To FastKart</h3>
                        </div>

                        <div class="input-box">
                            <form method="POST" > <!-- This form will submit to login.php -->
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" id="text" name="username" placeholder="Username" required>
                                        <label for="email">Username</label>
                                    </div>
                                </div>
                                </br>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                </br>
                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit" name="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
   
    </section>

    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/bootstrap/popper.min.js"></script>

    <!-- feather icon js-->
    <script src="../assets/js/feather/feather.min.js"></script>
    <script src="../assets/js/feather/feather-icon.js"></script>

    <!-- Slick js-->
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/slick/slick-animation.min.js"></script>
    <script src="../assets/js/slick/custom_slick.js"></script>

    <!-- Lazyload Js -->
    <script src="../assets/js/lazysizes.min.js"></script>

    <!-- script js -->
    <script src="../assets/js/script.js"></script>

    <!-- thme setting js -->
    <script src="../assets/js/theme-setting.js"></script>
</body>


<!-- Mirrored from themes.pixelstrap.com/fastkart/front-end/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Dec 2023 02:01:07 GMT -->
</html>
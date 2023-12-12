<?php
session_start();
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

$genres = ['All', 'Adventure', 'Horror', 'Comedy', 'Biography', 'Fantasy'];

// Filter books based on the selected genre
$filteredBooks = $books; // Initialize with all books by default

if (isset($_GET['selected_genre']) && in_array($_GET['selected_genre'], $genres)) {
    $selectedGenre = $_GET['selected_genre'];
    $filteredBooks = array_filter($books, function ($book) use ($selectedGenre) {
        return $book['Genre'] === $selectedGenre;
    });
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the Add to Cart button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
    $bookId = $_POST['bookId'];

    // Check if the book already exists in the cart
    $bookIndex = array_search($bookId, array_column($_SESSION['cart'], 'BookId'));

    if ($bookIndex !== false) {
        // If book exists, increment its quantity by 1
        $_SESSION['cart'][$bookIndex]['Quantity']++;
    } else {
        // If book doesn't exist, add it to the cart with a quantity of 1
        $bookDetails = [
            'BookId' => $_POST['bookId'],
            'BookTitle' => $_POST['bookTitle'],
            'BookImagePath' => "../assets/" . $_POST['bookImagePath'],
            'Price' => $_POST['bookPrice'],
            'Quantity' => 1,
            // Add more details as needed
        ];

        // Add book details to the cart array in session
        $_SESSION['cart'][] = $bookDetails;
    }
}
?>


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
    <title>Shop Category</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">

    <!-- wow css -->
    <link rel="stylesheet" href="../assets/css/animate.min.css" />

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
    
    <!-- Loader End -->

    <!-- Header Start -->
    <header class="pb-md-4 pb-0">
        <div class="top-nav top-header sticky-header">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                            </button>
                            <a href="shop.php" class="web-logo nav-logo">
                                <img src="../assets/images/logo/1.png" class="img-fluid blur-up lazyload" alt="">
                            </a>
                            <div class="rightside-box">
                                <div class="search-full">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i data-feather="search" class="font-light"></i>
                                        </span>
                                        <input type="text" class="form-control search-type" placeholder="Search here..">
                                        <span class="input-group-text close-search">
                                            <i data-feather="x" class="font-light"></i>
                                        </span>
                                    </div>
                                </div>
                                <ul class="right-side-menu">
                                   
                                    <li class="right-side">
                                        <a href="wishlist.html" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <div class="onhover-dropdown header-badge">
                                            <button type="button" class="btn p-0 position-relative header-wishlist">
                                                <i data-feather="shopping-cart"></i>
                                                <span class="position-absolute top-0 start-100 translate-middle badge">
                                                    <?php echo count($_SESSION['cart']); ?>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>

                                            <div class="onhover-div">
                                                <ul class="cart-list">
                                                    <?php foreach ($_SESSION['cart'] as $cartItem) { ?>
                                                        <li class="product-box-contain">
                                                            <div class="drop-cart">
                                                                <a href="product-left-thumbnail.html" class="drop-image">
                                                                    <img src="../assets/<?php echo $cartItem['BookImagePath']; ?>" class="blur-up lazyload" alt="">
                                                                </a>

                                                                <div class="drop-contain">
                                                                    <a href="product-left-thumbnail.html">
                                                                        <h5><?php echo $cartItem['BookTitle']; ?></h5>
                                                                    </a>
                                                                    <h6><span><?php echo $cartItem['Quantity']; ?> x </span> <?php echo $cartItem['Price']; ?></h6>
                                                                    
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>

                                                    <!-- Add total price calculation here if needed -->

                                                <div class="button-group">
                                                    <a href="cart.php" class="btn btn-sm cart-button">View Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="user"></i>
                                            </div>
                                            <?php
                                            if(isset($_SESSION['UserId']) && isset($_SESSION['UserType']) && $_SESSION['UserType'] === 'Regular') {
                                                echo '<div class="delivery-detail">';
                                                echo '<h6>Hello, ' . $_SESSION['Firstname'] . '</h6>';
                                                echo '<h5><a href="#" id="logoutbtn">Logout</a></h5>';
                                                echo '</div>';
                                            } else {
                                                echo '<div class="delivery-detail">';
                                                echo '<h6>Hello,</h6>';
                                                echo '<h5><a href="login.php">Login</a></h5>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    

    
    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-5 g-3">
                <div class="col-xxl-9">
                    <div class="cart-table">
                        <div class="table-responsive-xl">
                            <table class="table">
                                <tbody>
                                <?php foreach ($_SESSION['cart'] as $cartItem) { ?>
                                    <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="product-left-thumbnail.html" class="product-image">
                                                        <img src="<?php echo $cartItem['BookImagePath']; ?>"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="product-left-thumbnail.html"><?php echo $cartItem['BookTitle']; ?></a>
                                                            </li>

                                                            <li>
                                                                <h5 class="text-content d-inline-block"></h5>
                                                                <span></span>
                                                                <span class="text-content"></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h6 class="theme-color">CAD <?php echo $cartItem['Price']; ?></h6>
                                            </td>

                                            <td class="quantity">
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <input class="form-control  theme-color input-number qty-input" type="text"
                                                                name="quantity" value="<?php echo $cartItem['Quantity']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>CAD <?php echo $cartItem['Price'] * $cartItem['Quantity']; ?></h5>
                                            </td>

                                            <td class="save-remove">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3">
                    <div class="summery-box p-sticky">
                        <div class="summery-header">
                            <h3>Cart Total</h3>
                        </div>

                        <ul class="summery-total">
                            <li class="list-total border-top-0">
                                <h4>Total (USD)</h4>
                                <h4 class="price theme-color" id="totalPrice">$132.58</h4>
                            </li>
                        </ul>

                        <div class="button-group cart-button">
                            <ul>
                                <li>
                                    <button onclick="location.href = 'invoice.php';"
                                        class="btn btn-animation proceed-btn fw-bold">Proceed To Checkout</button>
                                </li>

                                <li>
                                    <button onclick="location.href = 'store.php';"
                                        class="btn btn-light shopping-button text-dark">
                                        <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->
    

    <!-- Footer Section Start -->
    <footer class="section-t-space">
        <div class="container-fluid-lg">

            <div class="sub-footer section-small-space">
                <div class="reserve">
                    <h6 class="text-content">© 2023</h6>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    

    

    <!-- Deal Box Modal Start -->
    <!-- Add to cart Modal End -->

  

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <!-- jquery ui-->
    <script src="../assets/js/jquery-ui.min.js"></script>

    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/bootstrap/bootstrap-notify.min.js"></script>
    <script src="../assets/js/bootstrap/popper.min.js"></script>

    <!-- feather icon js-->
    <script src="../assets/js/feather/feather.min.js"></script>
    <script src="../assets/js/feather/feather-icon.js"></script>

    <!-- Lazyload Js -->
    <script src="../assets/js/lazysizes.min.js"></script>

    <!-- Slick js-->
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/slick/slick-animation.min.js"></script>
    <script src="../assets/js/slick/custom_slick.js"></script>

    <!-- Price Range Js -->
    <script src="../assets/js/ion.rangeSlider.min.js"></script>

    <!-- Quantity js -->
    <script src="../assets/js/quantity-2.js"></script>

    <!-- sidebar open js -->
    <script src="../assets/js/filter-sidebar.js"></script>

    <!-- WOW js -->
    <script src="../assets/js/wow.min.js"></script>
    <script src="../assets/js/custom-wow.js"></script>

    <!-- script js -->
    <script src="../assets/js/script.js"></script>

    <!-- thme setting js -->
    <script src="../assets/js/theme-setting.js"></script>

    <script>
    // JavaScript function to filter books based on the selected genre
    function filterBooks(select) {
        const selectedGenre = select.value;

        if(selectedGenre === "All")
        {
            window.location.href = 'store.php';
        }
        else
        {
            window.location.href = 'store.php?selected_genre=' + selectedGenre;
        }
        
    }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Find the Clear Cart button
            const clearCartBtn = document.getElementById('clearCartBtn');

            // Attach a click event listener to the Clear Cart button
            clearCartBtn.addEventListener('click', function() {
                // Perform an AJAX request to clear the cart
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'clear_cart.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Cart cleared successfully, you can update UI or perform any additional actions
                        alert('Cart has been cleared!');
                        // Optionally, you can reload specific parts of the page or update the UI
                        location.reload(); // Reload the page to reflect the cleared cart
                    } else {
                        // Handle errors if needed
                        console.error('Error clearing cart:', xhr.responseText);
                    }
                };

                // Send the AJAX request
                xhr.send();
            });
    });
    </script>

    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const logOutBtn = document.getElementById('logoutbtn');

                logOutBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Perform an AJAX request to logout
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'logout.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Logout successful
                            alert('Logged out successfully!');
                            window.location.href = 'store.php'; // Redirect to login page after logout
                        } else {
                            // Handle errors if needed
                            console.error('Error during logout:', xhr.responseText);
                        }
                    };

                    xhr.send(); // Send the AJAX request for logout
                });
            });
    </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Function to calculate the total price
                function calculateTotal() {
                    const cartItems = <?php echo json_encode($_SESSION['cart']); ?>; // Get the cart items from PHP

                    // Calculate the total price
                    let totalPrice = 0;
                    cartItems.forEach(function(cartItem) {
                        totalPrice += cartItem['Price'] * cartItem['Quantity'];
                    });

                    return totalPrice;
                }

                // Function to update the total price displayed in the HTML
                function updateTotalPrice() {
                    const totalPrice = calculateTotal();
                    const totalPriceElement = document.getElementById('totalPrice'); // Get the total price element

                    // Update the HTML content with the new total price
                    if (totalPriceElement) {
                        totalPriceElement.textContent = '$' + totalPrice.toFixed(2); // Format the total price
                    }
                }

                // Call the function initially to set the total price
                updateTotalPrice();

                // You can call this function whenever there's an update in the cart, like adding/removing items
                // For example, after updating the cart via AJAX, call updateTotalPrice() to update the displayed total.
            });
        </script>


</body>



</html>
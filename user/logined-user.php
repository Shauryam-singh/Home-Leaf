<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../config.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - Home Leaf</title>
    <link rel="stylesheet" href="user.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href="../images/Logo.png" type="image/x-icon">
</head>
<body>

    <div class="scroll-up-btn show">
        <i class='bx bx-chevron-up'></i>
    </div>

    <nav class="navbar">
        <div class="container">
            <div class="left">
                <div class="logo">
                    <a href="../index.php"><img src="../images/Logo.png" alt="Logo" draggable="false"></a>
                </div>
            </div>
            <div class="searchbox">   
                <input placeholder="Search for groceries" class="desktop-searchBar" value=""
                data-reactid="904">
            </div>
            <div class="right">
                <div class="cart">
                    <a href="../cart/cart.php"><i class='bx bx-cart'></i></a>
                </div>
                <div class="user">
                    <a href="logined-user.php"><i class='bx bx-user-circle'></i></a>
                </div>
            </div>
        </div><div class="nav2">
            <div class="container">
                <div class="dropdown">
                    <button class="dropbtn">Shop with category ▼</button>
                    <div class="dropdown-content">
                        <a href="../fruits-vegitables/fruits-vegitables.html">Fruit & Vegetable</a>
                        <a href="#">Foodgrains, Oil & Masala</a>
                        <a href="#">Bakery, Cakes & Dairy</a>
                        <a href="#">Beverages</a>
                        <a href="#">Snacks</a>
                    </div>
                </div>
                <div class="others">
                    <a href="">Exotic Fruits & Veggies</a>
                </div>
                <div class="others">
                    <a href="">Tea</a>
                </div>
                <div class="others">
                    <a href="">Ghee</a>
                </div>
                <div class="others">
                    <a href="">Fresh Vegetables</a>
                </div>
                <div class="others">
                    <a href="">Milk</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="profile">
        <div class="container">
            <div class="left">
                <div class="pfp">
                    <img src="../images/default-avatar.png" alt="" draggable="false">
                    <div class="details">
                        <div class="heading">
                            <h1>Details</h1>
                        </div>
                        <div class="content">
                            <div class="name">
                                <p>Username</p>   
                                <h4><?php echo htmlspecialchars($_SESSION["username"]); ?></h4>
                            </div>
                            <div class="email">
                                <p>Email</p>
                                <h4><?php echo htmlspecialchars($_SESSION["email"]); ?></h4>
                            </div>
                            <div class="phone">
                                <p>Phone Number</p>
                                <h4><?php echo htmlspecialchars($_SESSION["mobile_number"]); ?></h4>
                            </div>
                            
                            <?php if(isset($_SESSION["loc"]) && !empty($_SESSION["loc"])): ?>
                                <div class="address">
                                    <p>Address</p>
                                    <h4><?php echo htmlspecialchars($_SESSION["loc"]); ?></h4>
                                </div>
                            <?php else: ?>
                                <div class="address">
                                    <p>Address</p>
                                    <h4>Add Address</h4>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($_SESSION["Pincode"]) && !empty($_SESSION["Pincode"])): ?>
                                <div class="pincode">
                                    <p>Pincode</p>
                                    <h4><?php echo htmlspecialchars($_SESSION["Pincode"]); ?></h4>
                                </div>
                            <?php else: ?>
                                <div class="pincode">
                                    <p>Pincode</p>
                                    <h4>Add Pincode</h4>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($_SESSION["City"]) && !empty($_SESSION["City"])): ?>
                                <div class="city">
                                    <p>City</p>
                                    <h4><?php echo htmlspecialchars($_SESSION["City"]); ?></h4>
                                </div>
                            <?php else: ?>
                                <div class="city">
                                    <p>City</p>
                                    <h4>Add City</h4>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($_SESSION["Country"]) && !empty($_SESSION["Country"])): ?>
                                <div class="Country">
                                    <p>Country</p>
                                    <h4><?php echo htmlspecialchars($_SESSION["Country"]); ?></h4>
                                </div>
                            <?php else: ?>
                                <div class="country">
                                    <p>Country</p>
                                    <h4>Add Country</h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="login-btns">
                    <a href="../logout.php"><button>Sign Out</button></a>
                </div>
            </div>
            <div class="right">
                <div class="heading">
                    <h1>Your Profile</h1>
                </div>
                <div class="about-you">

                    <a href="../orders/order.php" style="color: black;">
                        <div class="card">
                            <div class="card-img">
                                <img src="https://png.pngtree.com/png-vector/20220606/ourmid/pngtree-box-parcel-icon-isometric-vector-png-image_4877724.png" alt="" draggable=false>
                            </div>
                            <div class="content">
                                <h3>Your Order</h3>
                                <p>Track, return or buy things again</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="../update-user/login-security/login-security.php" style="color: black;">
                        <div class="card">
                            <div class="card-img">
                                <img src="https://m.media-amazon.com/images/G/31/x-locale/cs/ya/images/sign-in-lock._CB485931504_.png" alt="" draggable=false>
                            </div>
                            <div class="content"><h3>Login And Security</h3>
                                <p>Update your account information</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="../update-user/your-address/your-address.php" style="color: black;">
                        <div class="card">
                            <div class="card-img">
                                <img src="https://m.media-amazon.com/images/G/31/x-locale/cs/ya/images/address-map-pin._CB485934183_.png" alt="" draggable=false>
                            </div>
                            <div class="content"><h3>Your Address</h3>
                                <p>Edit addresses for orders</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="../contact/contact.php" style="color: black;">
                        <div class="card">
                            <div class="card-img">
                                <img src="https://m.media-amazon.com/images/G/31/x-locale/cs/help/images/gateway/self-service/contact_us._CB623781998_.png" alt="" draggable=false>
                            </div>
                            <div class="content"><h3>Contact Us</h3>
                                <p></p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section>
        
    <footer>
        <div class="footer">
            <div class="container">
                <div class="left">
                    <img src="../images/Logo.png" alt="Logo">
                    <h1>Home Leaf</h1>
                </div>
                <div class="right">
                    <a href="../index.php">About Us</a>
                    <a href="#">Privacy Policy</a>
                    <a href="../terms-condition/terms.html">Terms And Conditions</a>
                    <a href="../contact/contact.php">Contact Us</a>
                    <a href="../faqs/FAQ.html">FAQs</a>
                </div>
            </div>
            <hr>
            <div class="bottom">
                <div class="left">
                    <p>© 2024 Home Leaf - All rights reserved</p>
                </div>
                <div class="right">
                    <a href="https://www.instagram.com/home._.leaf/" target="_blank"><i class="bx bxl-instagram"></i></a>
                    <a href="#"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
<script src="user.js"></script>

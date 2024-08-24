<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../config.php";

$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Home Leaf</title>
    <link rel="stylesheet" href="contact.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href= "../images/Logo.png" type="image/x-icon">
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
                    <a href="../user/logined-user.php"><i class='bx bx-user-circle'></i></a>
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

    <main>
        <div class="form-container">
            <form action="https://api.web3forms.com/submit" method="POST" id="contactForm">
                <h2>Contact Us</h2>
                <input type="hidden" name="access_key" value="4c08034a-3097-423c-9cd9-e5f250cdef9e">
                
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($username); ?>" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                <textarea name="message" placeholder="Message" required></textarea>

                <div class="h-captcha" data-captcha="true"></div>

                <button type="submit">Send Email</button>
            </form>
        </div>
    </main>
        
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
<script src="https://web3forms.com/client/script.js" async defer></script>
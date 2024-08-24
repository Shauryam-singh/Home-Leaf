<?php
// order.php
session_start();
require '../config.php'; // Database connection

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Fetch orders for the logged-in user
$userId = $_SESSION["id"];
$sql = "SELECT * FROM orders WHERE user_id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Error: Could not prepare the query: " . mysqli_error($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders - Home Leaf</title>
    <link rel="stylesheet" href="order.css">
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

    <div class="order">
        <div class="container">
            <div class="heading">
                <div class="topic">
                    <h4>Your Orders</h4>
                </div>
            </div>
            <div class="order-list">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="order-item">
                        <div class="order-details">
                            <p><strong>Order ID:</strong> <?php echo $row['user_id']; ?></p>
                            <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                            <p><strong>Payment Method:</strong> <?php echo $row['payment_method']; ?></p>
                            <p><strong>Total Price:</strong> ₹<?php echo $row['total_price']; ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
        
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

    <script src="order.js"></script>
</body>
</html>

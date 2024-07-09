<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../login.php");
    exit;
}

require_once "../../config.php";

$country = isset($_SESSION["Country"]) ? $_SESSION["Country"] : "";
$city = isset($_SESSION["City"]) ? $_SESSION["City"] : "";
$pincode = isset($_SESSION["Pincode"]) ? $_SESSION["Pincode"] : "";
$loc = isset($_SESSION["loc"]) ? $_SESSION["loc"] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_profile"])) {
        $newAddress = $_POST["address"];
        $newCountry = $_POST["c_country"];
        $newCity = $_POST["c_city"];
        $newPincode = $_POST["p_pincode"];

        $sql = "UPDATE users SET loc = ?, Country = ?, City = ?, Pincode = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $newAddress, $newCountry, $newCity, $newPincode, $_SESSION["id"]);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["loc"] = $newAddress;
                $_SESSION["Country"] = $newCountry;
                $_SESSION["City"] = $newCity;
                $_SESSION["Pincode"] = $newPincode;
                header("location: ../../user/logined-user.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Address - Home Leaf</title>
    <link rel="stylesheet" href="your-address.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href="../../images/Logo.png" type="image/x-icon">
</head>
<body>

    <div class="scroll-up-btn show">
        <i class='bx bx-chevron-up'></i>
    </div>

    <nav class="navbar">
        <div class="container">
            <div class="left">
                <div class="logo">
                    <a href="../../index.php"><img src="../../images/Logo.png" alt="Logo" draggable="false"></a>
                </div>
            </div>
            <div class="searchbox">   
                <input placeholder="Search for groceries" class="desktop-searchBar" value=""
                data-reactid="904">
            </div>
            <div class="right">
                <div class="cart">
                    <a href="../../cart/cart.php"><i class='bx bx-cart'></i></a>
                </div>
                <div class="user">
                <a href="../../user/logined-user.php"><i class='bx bx-user-circle'></i></a>
                </div>
            </div>
        </div><div class="nav2">
            <div class="container">
                <div class="dropdown">
                    <button class="dropbtn">Shop with category ▼</button>
                    <div class="dropdown-content">
                        <a href="../../fruits-vegitables/fruits-vegitables.html">Fruit & Vegetable</a>
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

    <section class="edit-profile">
        <h1>Your Address</h1>
        <div class="container">
            <div class="editprofile">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="c_country">Country</label>
                        <input type="text" id="c_country" name="c_country" value="<?php echo htmlspecialchars($country); ?>">
                    </div>
                    <div class="form-group">
                        <label for="p_pincode">Pincode</label>
                        <input type="text" id="p_pincode" name="p_pincode" value="<?php echo htmlspecialchars($pincode); ?>" class="form-input" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        
                    </div>
                    <div class="form-group">
                        <label for="address">Street Address, building, floor</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($loc); ?>">
                    </div>
                    <div class="form-group">
                        <label for="c_city">City</label>
                        <input type="text" id="c_city" name="c_city" value="<?php echo htmlspecialchars($city); ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
            
        </div>
    </section>
    
    <footer>
        <div class="footer">
            <div class="container">
                <div class="left">
                    <img src="../../images/Logo.png" alt="Logo">
                    <h1>Home Leaf</h1>
                </div>
                <div class="right">
                    <a href="../../index.php">About Us</a>
                    <a href="#">Privacy Policy</a>
                    <a href="../../terms-condition/terms.html">Terms And Conditions</a>
                    <a href="../../contact/contact.php">Contact Us</a>
                    <a href="../../faqs/FAQ.html">FAQs</a>
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

    <script src="your-address.js"></script>
</body>
</html>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../../config.php";

$username = $_SESSION["username"];
$email = $_SESSION["email"];
$mobile_number = $_SESSION["mobile_number"];
$username_err = $email_err = $current_password_err = $new_password_err = $confirm_password_err = $mobile_number_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process profile update
    if (isset($_POST["update_profile"])) {
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];
        $newMobile = $_POST["mobile_number"];

        if (!preg_match("/^[0-9]{10}$/", $newMobile)) {
            $mobile_number_err = "Please enter a valid 10-digit mobile number.";
        }

        $sql = "UPDATE users SET username = ?, email = ?, mobile_number = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $newUsername, $newEmail, $newMobile, $_SESSION["id"]);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["username"] = $newUsername;
                $_SESSION["email"] = $newEmail;
                $_SESSION["mobile_number"] = $newMobile;
                header("location: ../../user/logined-user.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    }

    // Process password change
    if (isset($_POST["change_password"])) {
        $currentPassword = $_POST["current_password"];
        $newPassword = $_POST["new_password"];
        $confirmPassword = $_POST["confirm_password"];

        // Validation
        // Add your validation logic here

        // Validate current password
        $sql = "SELECT password FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($currentPassword, $hashed_password)) {
                            if ($newPassword == $confirmPassword) {
                                // Update password
                                $sql_update = "UPDATE users SET password = ? WHERE id = ?";
                                if ($stmt_update = mysqli_prepare($link, $sql_update)) {
                                    $new_password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                                    mysqli_stmt_bind_param($stmt_update, "si", $new_password_hash, $_SESSION["id"]);
                                    if (mysqli_stmt_execute($stmt_update)) {
                                        // Password updated successfully
                                        header("location: ../../user/logined-user.php");
                                        exit;
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                                }
                            } else {
                                $confirm_password_err = "New password and confirm password do not match.";
                            }
                        } else {
                            $current_password_err = "Invalid current password.";
                        }
                    }
                }
            }
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
    <title>Login and Security - Home Leaf</title>
    <link rel="stylesheet" href="login-security.css">
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
                <a href="../user/logined-user.php"><i class='bx bx-user-circle'></i></a>
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

    <div class="home">
        <a href="../../user/logined-user.php">Back /</a>
        <span> Login And Security</span>
    </div>

    <section class="edit-profile">

        <h1>Login And Security</h1>
        <div class="container">
            <div class="editprofile">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="mobile_number" class="form-label">Primary Mobile Number:</label>
                        <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($mobile_number); ?>" class="form-input" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        <?php if (!empty($mobile_number_err)) { ?>
                            <span class="invalid-feedback"><?php echo $mobile_number_err; ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
            
            <div class="edit-password">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="current_password">Current Password:</label>
                        <input type="password" id="current_password" name="current_password" value="">
                        <?php if (!empty($current_password_err)) { ?>
                            <span class="invalid-feedback"><?php echo $current_password_err; ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password" value="">
                        <?php if (!empty($new_password_err)) { ?>
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" value="">
                        <?php if (!empty($confirm_password_err)) { ?>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
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

    <script src="login-security.js"></script>
</body>
</html>

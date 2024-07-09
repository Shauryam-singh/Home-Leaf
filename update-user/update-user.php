<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../config.php";

// Initialize variables
$username = "";
$email = "";
$loc = "";
$username_err = $email_err = $current_password_err = $new_password_err = $confirm_password_err = "";

// Check if session variables are set
if(isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}

if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}

if(isset($_SESSION["loc"])) {
    $loc = $_SESSION["loc"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process profile update
    if (isset($_POST["update_profile"])) {
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];
        $newAddress = $_POST["address"];

        // Check if a file is selected for upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatar_data = file_get_contents($_FILES['avatar']['tmp_name']);
        } else {
            // No file uploaded, set avatar_data to default avatar
            $avatar_data = file_get_contents("../images/default-avatar.png");
        }

        $sql = "UPDATE users SET username = ?, email = ?, avatar = ?, loc = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $newUsername, $newEmail, $avatar_data, $newAddress, $_SESSION["id"]);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["username"] = $newUsername;
                $_SESSION["email"] = $newEmail;
                $_SESSION["loc"] = $newAddress;
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
                                        header("location: ../user/logined-user.php");
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
    if (isset($_POST["update_address"])) {
        $newAddress = $_POST["address"];

        // Update the user's address in the database
        $sql = "UPDATE users SET loc = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $newAddress, $_SESSION["id"]);

            if (mysqli_stmt_execute($stmt)) {
                // Update the session variable with the new address
                $_SESSION["loc"] = $newAddress;

                // Redirect the user to the profile page
                header("location: ../user/logined-user.php");
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
    <title>Edit Profile - Home Leaf</title>
    <link rel="stylesheet" href="update-user.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href="../images/Logo.png" type="image/x-icon">
</head>
<body>

    <div class="scroll-up-btn show">
        <i class='bx bx-chevron-up'></i>
    </div>

    <nav class="navbar">
        <div class="max-width">
            <div class="left">
                <div class="logo">
                    <a href="../index.php"><img src="../images/Logo.png" alt="Logo" draggable="false"></a>
                </div>
            </div>
            <div class="searchbox">
                <i class='bx bx-search'></i>
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
        </div>
    </nav>

    <section class="edit-profile">
        <h1>EDIT YOUR PROFILE</h1>
        <div class="container">
            <div class="editprofile">
                <h2>Edit Details</h2>
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
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($loc); ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
            <div class="edit-avatar">
                <h2>Edit Avatar</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="avatar">Avatar:</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-primary">Update avatar</button>
                    </div>
                </form>
            </div>
            <div class="edit-password">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <h2>Change Password</h2>
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

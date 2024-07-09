<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $mobile_number = $email = "";
$username_err = $password_err = $confirm_password_err = $mobile_number_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate mobile number
    if (empty(trim($_POST["mobile_number"]))) {
        $mobile_number_err = "Please enter your mobile number.";
    } elseif (strlen(trim($_POST["mobile_number"])) < 10) {
        $mobile_number_err = "Invalid mobile number format.";
    } else {
        $mobile_number = trim($_POST["mobile_number"]);
    }

   // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format.";
    } else{
        $email = trim($_POST["email"]);
    }

    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($mobile_number_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, mobile_number, email) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_mobile_number, $param_email);
            
            // Set parameters
            $param_username = $username;
            $param_mobile_number = $mobile_number;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .wrapper {
            width: 90%;
            max-width: 400px;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: #666;
        }
        input[type="text"],
        input[type="password"],
        input[type="tel"],
        input[type="email"],
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        input[type="file"]:focus {
            border-color: #007bff;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        #password-strength-meter {
            height: 10px;
            width: 90%;
            margin: 10px auto;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .form-check-input {
            margin-right: 10px;
        }
        .invalid-feedback {
            color: #dc3545;
            text-align: left;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">    
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>  
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="<?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <div id="password-strength-meter"></div>
                <div id="password-strength-text"></div>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            <div class="form-group">    
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="<?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>  
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="tel" name="mobile_number" id="mobile_number" class="<?php echo (!empty($mobile_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_number; ?>" oninput="validateMobileNumber(this)">
                <span class="invalid-feedback"><?php echo $mobile_number_err; ?></span>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="terms_of_service" name="terms_of_service" required>
                <label class="form-check-label" for="terms_of_service">I agree to the <a href="../project/terms-condition/terms.html">Terms of Service</a></label>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>  

    <script>
        function validateMobileNumber(input) {
            input.value = input.value.replace(/\D/g, '');

            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('password');
            var meter = document.getElementById("password-strength-meter");
            var passwordStrengthText = document.getElementById('password-strength-text');

            passwordInput.addEventListener('input', function() {
                var password = passwordInput.value;
                var strength = 0;
                
                if (password.match(/[a-z]+/)) {
                    strength += 1;
                }
                if (password.match(/[A-Z]+/)) {
                    strength += 1;
                }
                if (password.match(/[0-9]+/)) {
                    strength += 1;
                }
                if (password.match(/[$@#&!]+/)) {
                    strength += 1;
                }
                
                if (password.length < 6) {
                    meter.style.backgroundColor = "#FF0000";
                    strength = 0;
                } else if (password.length < 8) {
                    meter.style.backgroundColor = "#FF8C00";
                    strength = 1;
                } else if (password.length < 10) {
                    meter.style.backgroundColor = "#FFA500";
                    strength = 2;
                } else if (password.length < 12) {
                    meter.style.backgroundColor = "#006400";
                    strength = 3;
                } else {
                    meter.style.backgroundColor = "#4CAF50";
                    strength = 4;
                }
                
                var strengthText = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
                passwordStrengthText.textContent = strengthText[strength];
            });
        });
    </script>
</body>
</html>

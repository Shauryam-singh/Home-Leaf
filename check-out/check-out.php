<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../config.php";

$order_id = ""; // Initialize variable to store the order ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["id"];
    $address = isset($_SESSION["loc"]) ? $_SESSION["loc"] : "";
    $paymentMethod = $_POST["payment_method"];
    $totalPrice = $_POST["total_price"];
    
    // Insert order into the database
    $sql = "INSERT INTO orders (user_id, address, payment_method, total_price) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "isss", $userId, $address, $paymentMethod, $totalPrice);
        
        if (mysqli_stmt_execute($stmt)) {
            // Get the last inserted ID
            $order_id = mysqli_insert_id($link);
            echo "<script>alert('Order placed successfully!');</script>";
        } else {
            echo "Error: Could not execute the query: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Could not prepare the query: " . mysqli_error($link);
    }
    
    mysqli_close($link);
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
    <title>Check Out - Home Leaf</title>
    <link rel="stylesheet" href="check-out.css">
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
            <div class="check-out-text">   
                <h1>Checkout</h1>
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

    <div class="checkout">
        <div class="container">
            <div class="details">
                <div class="address">
                    <div class="left">
                        <p>1</p><span>Delivery Address</span>
                    </div>
                    <div class="right">
                        <?php if(isset($_SESSION["loc"]) && !empty($_SESSION["loc"])): ?>
                            <div class="addresss">
                                <p><?php echo htmlspecialchars($_SESSION["loc"]); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="addresss">
                                <p>Add Address</p>
                            </div>
                        <?php endif; ?>
                        <a href="">Change</a>
                    </div>
                </div>
                <div class="payment">
                    <div class="left">
                        <p>2</p><span>Select a payment method</span>
                    </div>
                    <div class="right">
                        <form id="payment-form" method="POST" action="check-out.php">
                            <div class="payment-method">
                                <input type="radio" id="credit-card" name="payment_method" value="credit_card" checked>
                                <label for="credit-card"><i class='bx bx-credit-card'></i> Credit / Debit Card</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" id="upi" name="payment_method" value="upi">
                                <label for="upi"><i class='bx bx-qr-scan'></i></i> UPI / VPA</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" id="cod" name="payment_method" value="cod">
                                <label for="cod"><i class='bx bx-money'></i> Cash on Delivery</label>
                            </div>
                            <div id="payment-details"></div>
                            <input type="hidden" name="total_price" id="total_price">
                        </form>
                    </div>
                </div>
                <div class="review">
                    <div class="container">
                        <div class="left">
                            <p>3</p><span>Review items</span>
                        </div>
                        <div class="right">
                            <div class="delivery-date">
                                <p>Arriving 1 Jun 2024</p>
                            </div>
                            <div class="seller-detail">
                                <p>Item dispatched by Home Leaf</p>
                            </div>
                            <div class="display" id="cart-items"></div>
                        </div>
                        <div class="price">
                            <p>Total Price:</p>
                            <div id="review-total-price"></div>
                            <button class="check-out-btn">Place your order</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-confirmation-modal" id="order-confirmation-modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="tick-icon">
                        <i class='bx bxs-check-circle bx-tada'></i>
                    </div>
                    <h2>Order Confirmed!</h2>
                    <p>Thank you for your order. Your order has been successfully placed.</p>
                    <div class="amount">
                        <p>Total Amount: <span id="order-amount"><div id="confirm-total-price"></div></span></p>
                    </div>
                </div>
            </div>



            <div class="summary">
                <div class="container">
                    <div class="place-order">
                        <button class="check-out-btn">Place your order</button>
                        <p>By placing your order, you agree to Home Leaf's privacy notice and conditions of use.</p>
                    </div>
                    <div class="order-summary">
                        <h1>Order Summary</h1>
                        <div class="order-container">    
                            <div class="left">
                                <p>Items:</p>
                                <p>Delivery</p>
                            </div>
                            <div class="right">
                                <div id="summary-total-price"></div>
                                <span>Free</span>
                            </div>
                        </div>
                    </div>
                    <div class="total-price">
                        <div class="left">
                            <p>Order Total:</p>
                        </div>
                        <div class="right">
                            <div id="order-total-price"></div>
                        </div>
                    </div>
                </div>
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
                        <a href="../index.html">About Us</a>
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

    <script src="check-out.js"></script>
</body>
</html>

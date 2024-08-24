<?php
require_once "../../../config.php";
session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Function to handle review submission
function submitReview($link, $item_id, $user_id, $review, $rating) {
    $stmt = $link->prepare("INSERT INTO reviews (item_id, user_id, review, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $item_id, $user_id, $review, $rating);
    $stmt->execute();
    $stmt->close();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'], $_POST['rating']) && $user_id) {
    $item_id = 5; // Example item id, replace with your item id
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    
    // Call the function to submit the review
    submitReview($link, $item_id, $user_id, $review, $rating);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Function to display stars based on the rating
function displayStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= "<i class='bx bxs-star'></i>"; // Filled star
        } else {
            $stars .= "<i class='bx bx-star'></i>"; // Empty star
        }
    }
    return $stars;
}


// Function to fetch and display reviews
function displayReviews($link, $item_id) {
    $sql = "SELECT r.review, r.rating, r.timestamp, u.username 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.item_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display reviews
    while ($row = $result->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<p><strong>" . htmlspecialchars($row['username']) . "</strong> rated " . displayStars($row['rating']) . "</p>";
        echo "<p>" . htmlspecialchars($row['review']) . "</p>";
        echo "<p><em>Reviewed on " . $row['timestamp'] . "</em></p>";
        echo "</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGGI 2-Minute Instant Noodles  - Home Leaf</title>
    <link rel="stylesheet" href="../../items.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href= "../../../images/Logo.png" type="image/x-icon">
</head>
<body>

    <div class="scroll-up-btn show">
        <i class='bx bx-chevron-up'></i>
    </div>
    
    <nav class="navbar">
        <div class="container">
            <div class="left">
                <div class="logo">
                    <a href="../../../index.php"><img src="../../../images/Logo.png" alt="Logo" draggable="false"></a>
                </div>
            </div>
            <div class="searchbox">   
                <input placeholder="Search for groceries" class="desktop-searchBar" value=""
                data-reactid="904">
            </div>
            <div class="right">
                <div class="cart">
                    <a href="../../../cart/cart.php"><i class='bx bx-cart'></i></a>
                </div>
                <div class="user">
                    <a href="../../../user/logined-user.php"><i class='bx bx-user-circle'></i></a>
                </div>
            </div>
        </div><div class="nav2">
            <div class="container">
                <div class="dropdown">
                    <button class="dropbtn">Shop with category ▼</button>
                    <div class="dropdown-content">
                        <a href="../../../fruits-vegitables/fruits-vegitables.html">Fruit & Vegetable</a>
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
    
    <div class="item">
        <div class="item-container">
            <div class="icons">
                <div class="img1 active">
                    <img src="https://www.bigbasket.com/media/uploads/p/l/266160_24-maggi-masala-instant-noodles-vegetarian.jpg" alt="" style="border: #ffe9b8 2px solid;" draggable="false">
                </div>
                <div class="img2">
                    <img src="https://www.bigbasket.com/media/uploads/p/l/266160-2_1-maggi-masala-instant-noodles-vegetarian.jpg" alt="" draggable="false">
                </div>
            </div>
            
            <div class="main-img">
                <div class="img1 active">
                    <img src="https://www.bigbasket.com/media/uploads/p/l/266160_24-maggi-masala-instant-noodles-vegetarian.jpg" alt="" draggable="false">
                </div>
                <div class="img2">
                    <img src="https://www.bigbasket.com/media/uploads/p/l/266160-2_1-maggi-masala-instant-noodles-vegetarian.jpg" alt="" style="display: none;" draggable="false">
                </div>
            </div>
            
            <div class="content">
                <div class="heading">
                    <h3>MAGGI 2-Minute Instant Noodles</h3>
                </div>
                <div class="amount">
                    <label for="amount1">Amount:</label>
                    <select id="amount1" name="amount" onchange="calculatePrice('card1')">
                        <option value="70g">70g</option>
                        <option value="140g">140g</option>
                        <option value="280g">280g</option>
                        <option value="420g">420g</option>
                    </select>
                </div>
                <div class="max-price">
                    <span>MRP: </span><p id="mrp1">₹14</p>
                </div>
                <div class="price">
                    <p id="price1">Price: ₹14</p>
                </div>                
                <div class="include">
                    <p>(inclusive of all taxes)</p>
                </div>
                <div class="cart-btn">
                    <button onclick="addToCart(this)">Add to Cart</button>
                </div>
                <div class="buy-btn">
                    <button onclick="quickCheckout(this)">Buy Now</button>
                </div>
            </div>
        </div>
    </div>
    <div class="why-homelife">
        <div class="heading">
            <h3>Why choose Home Leaf</h3>
        </div>
        <div class="container">
            <div class="card">
                <img src="../../../images/items/Quality.png" alt="" draggable="false">
                <h3>Quality</h3>
                <p>You can trust</p>
            </div>
            <div class="card">
                <img src="../../../images/items/On-time.png" alt="" draggable="false">
                <h3>On time</h3>
                <p>Guarantee</p></div>
            <div class="card">
                <img src="../../../images/items/Free-shipping.png" alt="" draggable="false">
                <h3>Free</h3>
                <p>Delivery</p></div>
            <div class="card">
                <img src="../../../images/items/return.png" alt="" draggable="false">
                <h3>Return Policy</h3>
                <p>No Question asked</p>
            </div>
        </div>
    </div>

    <div class="about-items">
        <div class="heading">
            <h3>More about this item:</h3>
        </div>
        <div class="container">
            <div class="card">
                <h3>About the product</h3>
                <p>MAGGI 2-Minute Instant Masala Noodles is a favorite among people of all ages. MAGGI Masala instant noodles now come with the goodness of iron. Each portion (70g) of MAGGI masala noodles provides you with 15% of your daily iron requirement. It is just the perfect choice for those who need a quick and satisfying meal. MAGGI instant noodles are made with the choicest quality spices and ingredients to provide a great taste and experience.<br>Features:.</p>
                <li>Relish your favorite masala taste with MAGGI 2-Minute Instant Noodles</li>
                <li>Each serving (70 g) of MAGGI Masala Noodles provides 15% of the daily iron requirement</li>
                <li>MAGGI 2-Minute Masala Instant Noodles are made with the choicest quality spices</li>
                <li>Pick the truly good choice with MAGGI Masala Noodles</li>
                <li>MAGGI Noodles are easy to prepare </li>
            </div>
            <div class="card">
                <h3>Ingredients</h3>
                <li>NOODLES: Refined wheat flour (Maida), Palm oil, Iodized salt, Wheat gluten, Thickeners (508 & 412), Acidity regulators (501(i) & 500(i)) & Humectant (451(i)).</li>
                <li>MASALA TASTEMAKER: Mixed spices (25.6%) (Onion powder, Coriander powder, Turmeric powder, Red chili powder, Garlic powder, Cumin powder, Aniseed powder, Ginger</li>
            </div>
            <div class="card">
                <h3>Nutritional Facts</h3>
                <p>Per 70 g Serve:</p>
                <li>Energy: 269 kcal</li>
            </div>
            <div class="card">
                <h3>How to Use</h3>
                <p>Step 1: Break the noodle cake into 4 parts.</p>
                <p>Step 2: Add noodles and TASTEMAKER to 210 ml (approx. 1 cup) of boiling water</p>
            </div>  
        </div>
    </div>

    <div class="review-items">
        <div class="heading">
            <h3>Rating and Reviews</h3>
        </div>
        <div class="container">
            <?php
            if ($user_id) {
                // Show review submission form if the user is logged in
                echo '<form action="" method="post">
                        <label for="review">Your review:</label>
                        <textarea id="review" name="review" required></textarea>
                        <label for="rating">Your rating:</label>
                        <select id="rating" name="rating" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <button type="submit">Submit</button>
                    </form>';
            } else {
                // Show login button if the user is not logged in
                echo '<p>You must <a href="../../../user/login.php">log in</a> to submit a review.</p>';
            }
            
            // Display reviews
            displayReviews($link, 5); // Replace 1 with the appropriate item id
            ?>
        </div>
    </div>
        
    <footer>
            <div class="footer">
                <div class="container">
                    <div class="left">
                        <img src="../../../images/Logo.png" alt="Logo">
                        <h1>Home Leaf</h1>
                    </div>
                    <div class="right">
                        <a href="../../../index.php">About Us</a>
                        <a href="#">Privacy Policy</a>
                        <a href="../../../terms-condition/terms.html">Terms And Conditions</a>
                        <a href="../../../contact/contact.php">Contact Us</a>
                        <a href="../../../faqs/FAQ.html">FAQs</a>
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
<script src="maggie.js"></script>

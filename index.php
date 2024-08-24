<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Groceries - Home Leaf</title>
    <link rel="stylesheet" href="../project/homepage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href= "images/Logo.png" type="image/x-icon">
</head>
<body>

    <div class="scroll-up-btn show">
        <i class='bx bx-chevron-up'></i>
    </div>

    <nav class="navbar">
        <div class="container">
            <div class="left">
                <div class="logo">
                    <a href="index.php"><img src="images/Logo.png" alt="Logo" draggable="false"></a>
                </div>
            </div>
            <div class="searchbox">   
                <input placeholder="Search for groceries" class="desktop-searchBar" value=""
                data-reactid="904">
            </div>
            <div class="right">
                <div class="cart">
                    <a href="cart/cart.php"><i class='bx bx-cart'></i></a>
                </div>
                <div class="user">
                    <a href="user/logined-user.php"><i class='bx bx-user-circle'></i></a>
                </div>
            </div>
        </div>
    </nav>
    
    <section class="about">
        <div class="about">
            <nav class="sidebar">
                <a href="index.php">
                <div class="sidebar-link"><img src="../project/images/sidebar-images/house-blank.png">
                    <p>Home</p>
                </div></a>
                <a href="../project/pantry/pantry.html">
                <div class="sidebar-link"><img src="../project/images/sidebar-images/food.png">
                    <p>Pantry</p>
                </div></a>
                <a href="../project/contact/contact.php">
                <div class="sidebar-link"><img src="../project/images/sidebar-images/contact-mail.png">
                    <p>Contact Us</p>
                </div></a>
                <a href="../project/faqs/FAQ.html">
                <div class="sidebar-link"><img src="../project/images/sidebar-images/faq.png">
                    <p>FAQ</p>
                </div></a>
            </nav>
            <div class="container">
                <div class="left">
                    <div class="heading">
                        <h1>Groceries</h1>
                        <h3>In the moment.</h3>
                        <p>your groceries our responsbility</p>
                        <div class="shopbtn">
                            <a href="../project/pantry/pantry.html"><button class="shopbtn">Start Shopping</button></a>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="logoimg">
                        <img src="../project/images/Logo-remome-bg.png" alt="Logo" width="800px" draggable="false">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="details">
        <div class="details">
            <div class="detailimg">
                <img src="../project/images/details.jpg" alt="Details Image" draggable="false">
            </div>
            <div class="detailsheading">
                <h1>Daily essentials. Essential daily</h1>
            </div>
            <div class="detailscontent">
                <p>Tap your way from aisle to aisle and order what you need, when you need it.</p>
            </div>
        </div>
    </section>

    <section class="slideshow">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="../project/images/slideshow/veg and fruits.jpg" draggable="false" alt="slideshow1">
                <div class="caption">Peelin' fresh?</div>
            </div>
            <div class="mySlides fade">
                <img src="../project/images/slideshow/dairy.jpg" draggable="false" alt="slideshow2">
                <div class="caption">Think beyond nutrition!</div>
            </div>
            <div class="mySlides fade">
                <img src="../project/images/slideshow/daily.jpg" draggable="false" alt="slideshow3">
                <div class="caption">Daily Grabs.</div>
            </div>
            <div class="mySlides fade">
                <img src="../project/images/slideshow/chips.jpg" draggable="false" alt="slideshow4">
                <div class="caption">Eat.Sleep.Snack.Repeat!</div>
            </div>
            <div class="mySlides fade">
                <img src="../project/images/slideshow/Beverage.jpg" draggable="false" alt="slideshow5">
                <div class="caption">Need some refreshment?</div>
            </div>
            <div class="mySlides fade">
                <img src="../project/images/slideshow/sweets.jpg" draggable="false" alt="slideshow6">
                <div class="caption">Sweet.Sugar.Savory</div>
            </div>
        </div>
            <br>
            <div style="text-align:center">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span>
        </div>        
    </section>
    
    <section class="best-seller">
        <div class="container">
            <div class="heading">
                <h1>Best Seller</h1>
            </div>
            <div class="card-container">
            <div class="card" id="card1">
                    <a href="items/best-seller/apple/apple.php">
                    <div class="card-img">
                        <img src="https://hips.hearstapps.com/hmg-prod/images/red-fresh-apple-isolated-on-white-background-royalty-free-image-1627314996.jpg">
                    </div>
                    </a>
                    <div class="item-details">
                        <div class="item-name">
                            <h3>Red Apple</h3>
                        </div>
                        <div class="amount">
                            <label for="amount1">Amount:</label>
                            <select id="amount1" name="amount" onchange="calculatePrice('card1')">
                                <option value="500g">500g</option>
                                <option value="1kg">1kg</option>
                                <option value="2kg">2kg</option>
                            </select>
                        </div>
                        <div class="price">
                            <p id="price1">Price: ₹126</p>
                        </div>
                        <div class="cart-controls">
                            <div class="cart-btn">
                                <button onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="card2">
                    <a href="items/best-seller/kissan-jam/kissan-jam.php">
                    <div class="card-img">
                        <img src="https://m.media-amazon.com/images/I/61O5yWCA5gL._SX679_.jpg">
                    </div>
                    </a>
                    <div class="item-details">
                        <div class="item-name">
                            <h3>Kissan Mixed Fruit Jam</h3>
                        </div>
                        <div class="amount">
                            <label for="amount2">Amount:</label>
                            <select id="amount2" name="amount" onchange="calculatePrice('card2')">
                                <option value="200g">200g</option>
                                <option value="500g">500g</option>
                                <option value="700g">700g</option>
                            </select>
                        </div>
                        <div class="price">
                            <p id="price2">Price: ₹80</p>
                        </div>
                        <div class="cart-controls">
                            <div class="cart-btn">
                                <button onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card" id="card3">
                    <div class="card-img">
                        <a href="items/best-seller/amul-taza/amul-taza.php">
                        <img src="https://m.media-amazon.com/images/I/31mfAYMQctL.jpg">
                    </div>
                    </a>
                    <div class="item-details">
                        <div class="item-name">
                            <h3>Amul Taaza</h3>
                        </div>
                        <div class="amount">
                            <label for="amount3">Amount:</label>
                            <select id="amount3" name="amount" onchange="calculatePrice('card3')">
                                <option value="200ml">200ml</option>
                                <option value="500ml">500ml</option>
                                <option value="1L">1L</option>
                            </select>
                        </div>
                        <div class="price">
                            <p id="price3">Price: ₹16</p>
                        </div>
                        <div class="cart-controls">
                            <div class="cart-btn">
                                <button onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card" id="card4">
                        <a href="items/best-seller/maggie/maggie.php">
                    <div class="card-img">
                        <img src="https://m.media-amazon.com/images/I/51+n-hxLK9L._SY300_SX300_.jpg">
                    </div>
                    </a>
                    <div class="item-details">
                        <div class="item-name">
                            <h3>MAGGI 2-minute Noodles</h3>
                        </div>
                        <div class="amount">
                            <label for="amount4">Amount:</label>
                            <select id="amount4" name="amount" onchange="calculatePrice('card4')">
                                <option value="70g">70g</option>
                                <option value="140g">140g</option>
                                <option value="280g">280g</option>
                                <option value="420g">420g</option>
                            </select>
                        </div>
                        <div class="price">
                            <p id="price4">Price: ₹14</p>
                        </div>
                        <div class="cart-controls">
                            <div class="cart-btn">
                                <button onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="card5">
                    <a href="items/best-seller/fortune-refined-soyabean-oil/fortune-refined-soyabean-oil.php">
                    <div class="card-img">
                        <img src="https://www.jiomart.com/images/product/original/490005534/fortune-refined-soyabean-oil-1-l-product-images-o490005534-p490005534-0-202203151702.jpg">
                    </div>
                    </a>
                    <div class="item-details">
                        <div class="item-name">
                            <h3>Fortune Refined Soyabean Oil</h3>
                        </div>
                        <div class="amount">
                            <label for="amount5">Amount:</label>
                            <select id="amount5" name="amount" onchange="calculatePrice('card5')">
                                <option value="1L">1L</option>
                                <option value="2L">2L</option>
                            </select>
                        </div>
                        <div class="price">
                            <p id="price5">Price: ₹116</p>
                        </div>
                        <div class="cart-controls">
                            <div class="cart-btn">
                                <button onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="description">
        <div class="description">
            <div class="heading">
                <h1>What make Home Leaf special?</h1>
            </div>
                <div class="cards">
                <div class="des1">
                    <div class="container">
                        <img src="../project/images/homepage-cards/our-range.jpg" alt="img1">
                    </div>
                    <p>Our amazing range</p>
                </div>
                <div class="des2">
                    <div class="container">
                        <img src="../project/images/homepage-cards/great-value.jpg" alt="img2">
                    </div>
                    <p>Our great value</p>
                </div>
                <div class="des3">
                    <div class="container">
                        <img src="../project/images/homepage-cards/del.jpg" alt="img3">
                    </div>
                    <p>Our super service</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer">
            <div class="container">
                <div class="left">
                    <img src="images/Logo.png" alt="Logo">
                    <h1>Home Leaf</h1>
                </div>
                <div class="right">
                    <a href="index.php">About Us</a>
                    <a href="#">Privacy Policy</a>
                    <a href="../terms-condition/terms.html">Terms And Conditions</a>
                    <a href="contact/contact.php">Contact Us</a>
                    <a href="faqs/FAQ.html">FAQs</a>
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
<script src="homepage.js"></script>

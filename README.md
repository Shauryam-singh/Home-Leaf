# Home Leaf: E-Grocery Store

Welcome to **Home Leaf**, an e-grocery store platform designed to provide users with a seamless online grocery shopping experience. This project is developed using HTML, CSS, JavaScript, and PHP.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Database Setup](#database-setup)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Introduction

Home Leaf is an e-grocery store application that allows users to browse, search, and purchase a variety of grocery items online. The platform aims to simplify the grocery shopping process by offering a user-friendly interface, easy navigation, and a secure checkout system.

## Features

- **User Registration and Login:** Secure user authentication system.
- **Product Browsing:** Browse grocery items by categories.
- **Search Functionality:** Search for products using keywords.
- **Shopping Cart:** Add, remove, and update items in the cart.
- **Order Management:** View order history and order details.
- **Responsive Design:** Optimized for both desktop and mobile devices.

## Installation

To run this project locally, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/home-leaf.git
   cd home-leaf
   ```

2. **Set Up the Environment:**
   - Ensure you have a web server like Apache or Nginx installed.
   - Make sure PHP is installed and configured.
   - Set up a MySQL database and import the provided SQL file.

3. **Configure Database:**
   - Update the `config.php` file with your database credentials.
   ```php
   define('DB_SERVER', 'your-server');
   define('DB_USERNAME', 'your-username');
   define('DB_PASSWORD', 'your-password');
   define('DB_NAME', 'your-database');
   ```

4. **Start the Server:**
   - If you are using Apache, place the project folder in the `htdocs` directory.
   - Please rename the folder to "project".
   - Start the Apache server and navigate to `http://localhost/project` in your web browser.

## Database Setup

To set up the database for Home Leaf, run the following SQL commands:


```php
CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(255) NOT NULL,
     password VARCHAR(255) NOT NULL,
     mobile_number VARCHAR(15),
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     email VARCHAR(255),
     loc VARCHAR(255),
     pincode VARCHAR(10),
     city VARCHAR(255),
     country VARCHAR(255)
);
```
```php
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```
```php
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL
);
```
```php
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    review TEXT NOT NULL,
    rating INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (item_id) REFERENCES items(id)
);
```
```php
INSERT INTO items (id, name) VALUES (1, 'Apple - Red Delicious');
```

## Usage

Once the installation is complete, you can start using Home Leaf:

1. **Register a New Account:**
   - Navigate to the registration page and create a new user account.

2. **Login:**
   - Use your credentials to log in to the application.

3. **Browse and Search Products:**
   - Explore various categories or use the search bar to find specific items.

4. **Add to Cart:**
   - Add desired products to your shopping cart.

5. **Checkout:**
   - Proceed to checkout, enter your shipping details, and place your order.

6. **Order Management:**
   - View your order history and track the status of your orders.

## Contributing

We welcome contributions from the community! To contribute to Home Leaf, follow these steps:

1. **Fork the Repository:**
   - Click the "Fork" button on the top right of this repository page.

2. **Clone Your Fork:**
   ```bash
   git clone https://github.com/your-username/home-leaf.git
   cd home-leaf
   ```

3. **Create a Branch:**
   ```bash
   git checkout -b feature-branch
   ```

4. **Make Your Changes:**
   - Implement your features or bug fixes.

5. **Commit and Push:**
   ```bash
   git add .
   git commit -m "Describe your changes"
   git push origin feature-branch
   ```

6. **Create a Pull Request:**
   - Go to the original repository and create a pull request from your forked repository.

## Contact

If you have any questions or suggestions, feel free to contact us:

- **Email:** contact.legitkiller@gmail.com

---

Thank you for using Home Leaf! Happy shopping!

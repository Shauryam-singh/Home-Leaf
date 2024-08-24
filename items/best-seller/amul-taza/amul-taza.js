$('.scroll-up-btn').click(function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
});

function calculatePrice(cardId) {
  var amountDropdown = document.getElementById('amount1');
  var priceDisplay = document.getElementById('price1');
  var mrpDisplay = document.getElementById('mrp1');

  var priceMap = {
      '200ml': { price: 16, mrp: 16 },
      '500ml': { price: 38, mrp: 38 },
      '1L': { price: 74, mrp: 74 }
  };

  var selectedAmount = amountDropdown.value;
  var selectedPrice = priceMap[selectedAmount].price;
  var selectedMRP = priceMap[selectedAmount].mrp;

  priceDisplay.textContent = 'Price: ₹' + selectedPrice;
  mrpDisplay.textContent = '₹' + selectedMRP;
}
function addToCart(button) {
  const item = button.closest('.item');
  const name = item.querySelector('.heading h3').textContent;
  const amount = item.querySelector('.amount select').value;
  const price = parseFloat(item.querySelector('.price p').textContent.split('₹')[1]);
  const imgSrc = item.querySelector('.img1.active img').src; // Get the image URL

  let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
  let existingItem = cartItems.find(cartItem => cartItem.name === name && cartItem.amount === amount);

  if (existingItem) {
      // If the item already exists in the cart, increment its quantity
      existingItem.quantity += 1;
  } else {
      // Otherwise, add a new item to the cart
      const cartItem = { name, amount, price, imgSrc, quantity: 1 };
      cartItems.push(cartItem);
  }
  
  // Store updated cart in localStorage
  localStorage.setItem('cartItems', JSON.stringify(cartItems));
  
  alert('Item added to cart!');
}

function quickCheckout(button) {
  const item = button.closest('.item');
  const name = item.querySelector('.heading h3').textContent;
  const amount = item.querySelector('.amount select').value;
  const price = parseFloat(item.querySelector('.price p').textContent.split('₹')[1]);
  const imgSrc = item.querySelector('.img1.active img').src;

  // Set the quickCheckOut cart to an empty array
  localStorage.setItem('quickCheckOut', JSON.stringify([]));

  // Create a new item object
  const newItem = { name, amount, price, imgSrc, quantity: 1 };

  // Store the new item in quickCheckOut localStorage
  localStorage.setItem('quickCheckOut', JSON.stringify([newItem]));

  // Alert the user that the item has been added for checkout
  alert('Item added for checkout!');

  // Redirect to quick-check-out.php
  window.location.href = '../../../check-out/quick-check-out/quick-check-out.php';
}
document.addEventListener("DOMContentLoaded", function() {
  displayCartItems();
});

function displayCartItems() {
  const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
  const cartContainer = document.getElementById('cart-items');
  const totalPriceContainer = document.getElementById('total-price');
  
  cartContainer.innerHTML = '';

  let totalPrice = 0;

  cartItems.forEach(item => {
      const cartItemDiv = document.createElement('div');
      cartItemDiv.classList.add('cart-item');
      
      const img = document.createElement('img');
      img.src = item.imgSrc;
      img.alt = item.name;
      cartItemDiv.appendChild(img);

      const details = document.createElement('div');
      details.classList.add('item-details');
      
      // Display item name with quantity
      const name = document.createElement('h3');
      name.textContent = `${item.quantity}x ${item.name}`;
      details.appendChild(name);

      const amount = document.createElement('p');
      amount.textContent = `Amount: ${item.amount}`;
      details.appendChild(amount);

      const price = document.createElement('p');
      price.textContent = `Price: ₹${item.price * item.quantity}`;
      details.appendChild(price);

      const removeButton = document.createElement('button');
      removeButton.textContent = 'Remove';
      removeButton.addEventListener('click', function() {
          removeItemFromCart(item);
      });
      details.appendChild(removeButton);

      cartItemDiv.appendChild(details);
      cartContainer.appendChild(cartItemDiv);

      totalPrice += item.price * item.quantity; // Update total price considering quantity
  });

  totalPriceContainer.textContent = `Total Price: ₹${totalPrice.toFixed(2)}`;
}


function removeItemFromCart(item) {
  let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
  cartItems = cartItems.filter(cartItem => cartItem.name !== item.name);
  localStorage.setItem('cartItems', JSON.stringify(cartItems));
  displayCartItems();
}

function clearCart() {
  localStorage.removeItem('cartItems');
  displayCartItems();
}

$('.scroll-up-btn').click(function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
});
function calculatePrice(cardId) {
    var amountDropdown = document.getElementById('amount' + cardId.slice(-1));
    var priceDisplay = document.getElementById('price' + cardId.slice(-1));

    var priceMap = {
        'card1': { '250g': 17, '500g': 34, '1kg': 78 },
        'card2': { '250g': 11, '500g': 22, '1kg': 44 },
        'card3': { '1pc - (approx. 400g to 600g)': 19},
        'card4': { '100g': 12, '250g': 30},
        'card5': { '500g': 16, '1kg': 32},
        'card6': { '250g': 10, '500g': 19, '1kg': 38},
        'card7': { '1kg': 36, '2kg': 72, '5kg': 180},
        'card8': { '1kg': 34, '2kg': 68, '5kg': 160}
    };

    var selectedAmount = amountDropdown.value;
    priceDisplay.textContent = 'Price: ₹' + priceMap[cardId][selectedAmount];
}
document.addEventListener("DOMContentLoaded", function () {
    const cardContainer = document.querySelector(".smart-basket .card-container");
    const cards = document.querySelectorAll(".smart-basket .card");
    const leftArrow = document.querySelector(".smart-basket .left-arrows");
    const rightArrow = document.querySelector(".smart-basket .right-arrow");
    const cardWidth = cards[0].offsetWidth;
    const numVisibleCards = 4;
    let startIndex = 0;
    function updateVisibility() {
        cards.forEach((card, index) => {
            if (index >= startIndex && index < startIndex + numVisibleCards) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
    function updateArrows() {
        leftArrow.style.display = startIndex === 0 ? "none" : "block";
        rightArrow.style.display = startIndex + numVisibleCards >= cards.length ? "none" : "block";
    }
    leftArrow.addEventListener("click", function () {
        if (startIndex > 0) {
            startIndex -= numVisibleCards;
            updateVisibility();
            updateArrows();
        }
    });
    rightArrow.addEventListener("click", function () {
        if (startIndex + numVisibleCards < cards.length) {
            startIndex += numVisibleCards;
            updateVisibility();
            updateArrows();
        }
    });
    updateVisibility();
    updateArrows();
});

function addToCart(button) {
    const item = button.closest('.card');
    const name = item.querySelector('.item-name h3').textContent;
    const amount = item.querySelector('.amount select').value;
    const price = parseFloat(item.querySelector('.price p').textContent.split('₹')[1]);
    const imgSrc = item.querySelector('.card-img img').src; // Get the image URL

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


document.addEventListener("DOMContentLoaded", function () {
    const paymentDetails = document.getElementById("payment-details");

    document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
        elem.addEventListener("change", function (event) {
            updatePaymentDetails(event.target.value);
        });
    });

    function updatePaymentDetails(paymentMethod) {
        paymentDetails.innerHTML = ""; // Clear previous details
        if (paymentMethod === "credit_card") {
            paymentDetails.innerHTML = `
                <div class="card-details">
                    <div class="cardnumber">
                        <label for="card-number">Card Number:</label>
                        <input type="text" id="card-number" name="card_number" maxlength="12" required>
                        <div id="card-type"></div> <!-- Updated here -->
                    </div><br>
                    
                    <div class="cardexpiry">
                        <label for="card-expiry">Expiry Date:</label>
                        <input type="text" id="card-expiry" name="card_expiry" placeholder="MM/YY" maxlength="5" required>
                    </div><br>
    
                    <div class="cardcvc">
                        <label for="card-cvc">CVC:</label>
                        <input type="text" id="card-cvc" name="card_cvc" maxlength="3" required>
                    </div><br>
                </div>
            `;
    
            document.getElementById("card-number").addEventListener("input", handleCardNumberInput);
            document.getElementById("card-cvc").addEventListener("input", handleCVCInput);
            document.getElementById("card-expiry").addEventListener("input", handleExpiryDateInput);
        } else if (paymentMethod === "upi") {
            paymentDetails.innerHTML = `
                <div class="upi-details">
                    <div class="upi">
                        <label for="upi">UPI:</label>
                        <input type="text" id="upi" name="upi" required>
                    </div><br>
                </div>
            `;

        } else if (paymentMethod === "cod") {
            paymentDetails.innerHTML = `
                <p>Cash on Delivery is selected. You will pay when the order is delivered.</p>
            `;
        }
    }

    // Set initial payment details
    updatePaymentDetails(document.querySelector('input[name="payment_method"]:checked').value);

    function handleCardNumberInput() {
        const cardNumberInput = document.getElementById("card-number");
        const cardTypeDisplay = document.getElementById("card-type");
    
        cardNumberInput.value = cardNumberInput.value.replace(/\D/g, '').substring(0, 12);
    
        const cardNumber = cardNumberInput.value;
        const cardType = getCardType(cardNumber);

        if (cardType) {
            const cardLogo = document.createElement("img");
            cardLogo.src = `../${cardType.toLowerCase()}-logo.png`; // Assuming card logo filenames are lowercase
    
            const cardTypeText = document.createTextNode(cardType);
    
            cardTypeDisplay.innerHTML = "";
            cardTypeDisplay.appendChild(cardLogo);
            cardTypeDisplay.appendChild(cardTypeText);
            
            cardNumberInput.classList.remove("invalid");
        } else {
            cardTypeDisplay.innerHTML = "Invalid Card Type";
            cardNumberInput.classList.add("invalid");
        }
    }

    function getCardType(cardNumber) {
        const cardPatterns = {
            "Visa": /^4/,
            "MasterCard": /^5[1-5]/,
            "American Express": /^3[47]/,
            "Diners Club": /^3(?:0[0-5]|[68])/,
            "Discover": /^6(?:011|5)/,
            "JCB": /^(?:2131|1800|35)/,
            "Rupay": /^(?:6521|6522)/,
            "Maestro": /^(?:5018|5020|5038|6304|6759|6761|6763)/
        };
        
        for (const [cardType, pattern] of Object.entries(cardPatterns)) {
            if (pattern.test(cardNumber)) {
                return cardType;
            }
        }
        return null;
    }

    function handleCVCInput() {
        const cvcInput = document.getElementById("card-cvc");
        cvcInput.value = cvcInput.value.replace(/\D/g, '').substring(0, 3); // Restrict input to 3 digits
    }

    function validateExpiryDate(expiryDate) {
        if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
            return false;
        }
        const [month, year] = expiryDate.split('/').map(Number);
        if (month < 1 || month > 12) {
            return false;
        }
        const currentYear = new Date().getFullYear() % 100;
        const currentMonth = new Date().getMonth() + 1;
        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            return false;
        }
        return true;
    }
    
    function handleExpiryDateInput() {
        const expiryInput = document.getElementById("card-expiry");
        expiryInput.value = expiryInput.value
            .replace(/\D/g, '')
            .substring(0, 4)
            .replace(/(\d{2})(\d)/, '$1/$2');
    }

    document.querySelectorAll('.check-out-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
            if (selectedPaymentMethod === "credit_card") {
                const cardNumber = document.getElementById("card-number").value;
                const cardExpiry = document.getElementById("card-expiry").value;
                const cardCVC = document.getElementById("card-cvc").value;
    
                if (!validateCardNumber(cardNumber)) {
                    alert("Invalid card number. Please enter 12 digits.");
                    return;
                }
    
                if (!validateExpiryDate(cardExpiry)) {
                    alert("Invalid expiry date. Use MM/YY format.");
                    return;
                }
    
                if (!validateCVC(cardCVC)) {
                    alert("Invalid CVC. Please enter 3 digits.");
                    return;
                }
            }
    
            const formData = new FormData(document.getElementById("payment-form"));
            fetch('quick-check-out.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log(result); // Log the result of the SQL query execution
                openOrderConfirmationModal(); // Open the modal
            })
            .catch(error => {
                console.error('Error:', error); // Log any errors that occur during the fetch request
                alert('An error occurred while placing the order. Please try again later.');
            });
        });
    });
    
    // Function to open the order confirmation modal
    function openOrderConfirmationModal() {
        const modal = document.getElementById("order-confirmation-modal");
        modal.classList.add("active");
    }
    
    // Function to close the order confirmation modal
    function closeOrderConfirmationModal() {
        const modal = document.getElementById("order-confirmation-modal");
        modal.classList.remove("active");
    }
    
    // Close the modal when the close button is clicked
    document.querySelector('.modal-content .close').addEventListener('click', closeOrderConfirmationModal);    

    function validateCardNumber(cardNumber) {
        return /^\d{12}$/.test(cardNumber);
    }

    function validateCVC(cvc) {
        return /^\d{3}$/.test(cvc);
    }

    displayQuickCheckOutItems();
updateQuickCheckOutTotalPriceDisplay();

function displayQuickCheckOutItems() {
    const quickCheckOutItems = JSON.parse(localStorage.getItem('quickCheckOut')) || [];
    const cartContainer = document.getElementById('cart-items');
    const reviewTotalPriceContainer = document.getElementById('review-total-price');
    const summaryTotalPriceContainer = document.getElementById('summary-total-price');
    const confirmTotalPriceContainer = document.getElementById('confirm-total-price');
    const orderTotalPriceContainer = document.getElementById('order-total-price');

    cartContainer.innerHTML = '';

    let totalPrice = 0;

    quickCheckOutItems.forEach(item => {
        const cartItemDiv = document.createElement('div');
        cartItemDiv.classList.add('cart-item');

        const img = document.createElement('img');
        img.src = item.imgSrc;
        img.alt = item.name;
        cartItemDiv.appendChild(img);

        const details = document.createElement('div');
        details.classList.add('item-details');

        const name = document.createElement('h3');
        name.textContent = `${item.quantity}x ${item.name}`;
        details.appendChild(name);

        const amount = document.createElement('p');
        amount.textContent = `Amount: ${item.amount}`;
        details.appendChild(amount);

        const price = document.createElement('p');
        price.textContent = `Price: ₹${item.price * item.quantity}`;
        details.appendChild(price);

        cartItemDiv.appendChild(details);
        cartContainer.appendChild(cartItemDiv);

        totalPrice += item.price * item.quantity;
    });

    const totalPriceText = `₹${totalPrice}`;
    reviewTotalPriceContainer.textContent = totalPriceText;
    summaryTotalPriceContainer.textContent = totalPriceText;
    confirmTotalPriceContainer.textContent = totalPriceText;
    orderTotalPriceContainer.textContent = totalPriceText;
}

function updateQuickCheckOutTotalPriceDisplay() {
    const totalPrice = calculateQuickCheckOutTotalPrice();
    document.getElementById("review-total-price").innerText = `₹${totalPrice}`;
    document.getElementById("summary-total-price").innerText = `₹${totalPrice}`;
    document.getElementById("order-total-price").innerText = `₹${totalPrice}`;
    document.getElementById("total_price").value = totalPrice;
}

function calculateQuickCheckOutTotalPrice() {
    let totalPrice = 0;
    const quickCheckOutItems = JSON.parse(localStorage.getItem('quickCheckOut')) || [];
    quickCheckOutItems.forEach(item => {
        totalPrice += item.price * item.quantity;
    });
    return totalPrice.toFixed(2);
}

});

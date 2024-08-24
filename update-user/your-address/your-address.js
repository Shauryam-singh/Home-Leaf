$('.scroll-up-btn').click(function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
});
document.querySelector('form').addEventListener('submit', function (e) {
    var country = document.getElementById('country').value;
    var pincode = document.getElementById('pincode').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;

    if (!validateCountry(country)) {
        alert("Please enter a valid country.");
        e.preventDefault();
    }

    if (!validatePincode(pincode)) {
        alert("Please enter a valid pincode.");
        e.preventDefault();
    }

    if (!validateCity(city)) {
        alert("Please enter a valid city.");
        e.preventDefault();
    }
});

function validateCountry(country) {
    return /^[a-zA-Z]+$/.test(country);
}

function validatePincode(pincode) {
    return /^\d{6}$/.test(pincode);
}

function validateCity(city) {
    return /^[a-zA-Z]+$/.test(city);
}
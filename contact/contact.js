function sendEmail() {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const message = document.getElementById("message").value;

  const mailtoLink = `mailto:contact.legitkiller@gmail.com?subject=Contact%20Us&body=Name:%20${name}%0AEmail:%20${email}%0AMessage:%20${message}`;

  window.location.href = mailtoLink;
}
$('.scroll-up-btn').click(function(){
  $('html, body').animate({scrollTop : 0},800);
  return false;
});
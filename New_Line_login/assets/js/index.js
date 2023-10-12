const urlParams = new URLSearchParams(window.location.search);
const Get_orderId = urlParams.get('orderID');
localStorage.setItem('orderID', Get_orderId);
var textElements = document.getElementsByClassName("carousel-text");
var textIndex = 0;

function switchText() {
for (var i = 0; i < textElements.length; i++) {
  textElements[i].classList.remove("active");
}
textIndex++;
if (textIndex >= textElements.length) {
  textIndex = 0;
}
textElements[textIndex].classList.add("active");
}
// Store the titles in an array
var titles = ["ttomoru welcome", "ถ้าคุณพร้อมแล้วไปรับรหัสกันได้เลย"];

// Function to change the page title
function changeTitle() {
var currentTitle = document.title;
var currentIndex = titles.indexOf(currentTitle);
var newIndex = (currentIndex + 1) % titles.length;
document.title = titles[newIndex];
}
var myIndex = 0;
carousel();

function carousel() {
var i;
var x = document.getElementsByClassName("mySlides");
for (i = 0; i < x.length; i++) {
x[i].style.display = "none";
}
myIndex++;
if (myIndex > x.length) {
myIndex = 1
}
x[myIndex - 1].style.display = "block";
setTimeout(carousel, 2500);
}

// Example usage: switch title every 3 seconds
setInterval(changeTitle, 3000);

setInterval(switchText, 5000);
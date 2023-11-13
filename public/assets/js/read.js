const button1 = document.getElementById("first-picture");
const button2 = document.getElementById("second-picture");
const choice = document.getElementById("choice");
button1.addEventListener("click", () => {
    button1.style.opacity = 1;
    button2.style.opacity = 0.5;
    choice.value = "read";
});

button2.addEventListener("click", () => {
    button1.style.opacity = 0.5;
    button2.style.opacity = 1;
    choice.value = "notyet";
});
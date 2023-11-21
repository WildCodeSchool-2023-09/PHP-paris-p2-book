const buttonRead = document.getElementById("firstPicture");
const buttonNotYet = document.getElementById("secondPicture");
const choice = document.getElementById("choice");
buttonRead.addEventListener("click", () => {
    buttonRead.style.opacity = 1;
    buttonNotYet.style.opacity = 0.5;
    choice.value = "read";
});

buttonNotYet.addEventListener("click", () => {
    buttonRead.style.opacity = 0.5;
    buttonNotYet.style.opacity = 1;
    choice.value = "notyet";
});
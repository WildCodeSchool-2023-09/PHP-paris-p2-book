const userMenu = document.querySelector("#user-menu");
const userBtn = document.querySelector("#btn-user");
const userBtnClose = document.querySelector("#btn-user-close");

console.log("js script working");

userBtn.addEventListener('click', function() {
    userMenu.style.display = "block";
    userBtn.style.visibility = "hidden";
    console.log("opened user menu");
});

userBtnClose.addEventListener('click', function() {
    userMenu.style.display = "none";
    userBtn.style.visibility = "visible";
    console.log("closed user menu");
});
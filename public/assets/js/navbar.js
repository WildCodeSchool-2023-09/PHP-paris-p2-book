const userMenu = document.querySelector("#user-menu");
const userBtn = document.querySelector("#btn-user");
const userBtnClose = document.querySelector("#btn-user-close");

userBtn.addEventListener('click', function() {
    userMenu.style.display = "block";
    userBtn.style.visibility = "hidden";
});

userBtnClose.addEventListener('click', function() {
    userMenu.style.display = "none";
    userBtn.style.visibility = "visible";
});
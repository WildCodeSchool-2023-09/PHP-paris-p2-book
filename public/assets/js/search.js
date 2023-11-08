console.log("js script");

const btnSettings = document.querySelector('.settings');
const searchBox = document.querySelector('#search-box');

btnSettings.addEventListener('click', function() {
    searchBox.style.display = "flex";
});
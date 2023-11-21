const synopsis = document.getElementById("synopsis");
const details = document.getElementById("details");
const synopsisTitle = document.getElementById("synopsisTitle");
const detailTitle = document.getElementById("detailTitle");

synopsisTitle.addEventListener("click", () => {
    synopsis.style.display="block";
    details.style.display="none";
});

detailTitle.addEventListener("click", () => {
    details.style.display="block";
    synopsis.style.display="none";
});
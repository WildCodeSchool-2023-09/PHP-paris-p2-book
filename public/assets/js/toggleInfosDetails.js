const synopsis = document.getElementById("synopsis");
const details = document.getElementById("details");
const review = document.getElementById("review")
const synopsisTitle = document.getElementById("synopsisTitle");
const detailTitle = document.getElementById("detailTitle");
const reviewTitle = document.getElementById("reviewTitle");

synopsisTitle.addEventListener("click", () => {
    synopsis.style.display="block";
    details.style.display="none";
    review.style.display="none";
});

detailTitle.addEventListener("click", () => {
    details.style.display="block";
    synopsis.style.display="none";
    review.style.display="none";
});

reviewTitle.addEventListener("click", () => {
    review.style.display="block";
    details.style.display="none";
    synopsis.style.display="none";
});
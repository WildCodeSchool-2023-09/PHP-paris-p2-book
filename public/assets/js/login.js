const modalContainer = document.getElementById("modal-container");
const modalTriggers = document.querySelectorAll(".modal-trigger");
const section1 = document.getElementById("section1");
const section2 = document.getElementById("middle");
const section3 = document.getElementById("section3");


modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal))

function toggleModal() {
    modalContainer.classList.toggle("active");
    section1.classList.toggle("active");
    section2.classList.toggle("active");
    section3.classList.toggle("active");
}
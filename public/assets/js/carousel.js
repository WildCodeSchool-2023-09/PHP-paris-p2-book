const slideWidth = document.querySelector(".slide").clientWidth;

function sliderScript(slidesContainerSelector) {
    const slidesContainer = document.querySelector(slidesContainerSelector +" .slides-container");

    const leftBtn = document.querySelector(slidesContainerSelector + " .slides-btn.left");
    const middleBtn = document.querySelector(slidesContainerSelector + " .slides-btn.middle");
    const rightBtn = document.querySelector(slidesContainerSelector + " .slides-btn.right");

    leftBtn.addEventListener("click", () => {
        slidesContainer.scrollTo(0, 0);
    });

    middleBtn.addEventListener("click", () => {
        slidesContainer.scrollTo(slideWidth, 0);
    });

    rightBtn.addEventListener("click", () => {
        slidesContainer.scrollTo(2 * slideWidth, 0);
    });
}

sliderScript("#trending");
sliderScript("#reviews");
sliderScript("#for-you");
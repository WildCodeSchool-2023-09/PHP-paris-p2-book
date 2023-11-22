const noteStars = document.querySelectorAll(".noteStar");
const note = document.querySelector("#noteResult");

for (star of noteStars) {
    star.addEventListener("mouseover", function () {
        resetNoteStars();
        this.classList.remove("lar");
        this.classList.add("las");


        let previousStar = this.previousElementSibling;
        while (previousStar) {
            previousStar.classList.remove("lar");
            previousStar.classList.add("las");
            previousStar = previousStar.previousElementSibling;
        }
    });

    star.addEventListener("click", function () {
        note.value = this.dataset.value;
    });

    star.addEventListener("mouseout", function () {
        resetNoteStars(note.value);
    });
}

function resetNoteStars(note = 0) {
    for (star of noteStars) {
        if (star.dataset.value > note) {
            star.classList.remove("las");
            star.classList.add("lar");
        } else {
            star.classList.remove("lar");
            star.classList.add("las");
        }

    }
}
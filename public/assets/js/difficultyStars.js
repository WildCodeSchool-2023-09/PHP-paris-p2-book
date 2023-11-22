const difficultyStars = document.querySelectorAll(".difficultyStar");
const difficultyNote = document.querySelector("#difficultyResult");

for (star of difficultyStars) {
    star.addEventListener("mouseover", function () {
        resetDifficultyStars();
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
        difficultyNote.value = this.dataset.value;
    });

    star.addEventListener("mouseout", function () {
        resetDifficultyStars(difficultyNote.value);
    });
}

function resetDifficultyStars(note = 0) {
    for (star of difficultyStars) {
        if (star.dataset.value > note) {
            star.classList.remove("las");
            star.classList.add("lar");
        } else {
            star.classList.remove("lar");
            star.classList.add("las");
        }

    }
}
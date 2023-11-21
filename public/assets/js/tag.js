const allCard = document.getElementsByClassName("tag_card");
const tagMenu = document.getElementById("tag_menu");

tagMenu.addEventListener("change", function () {
    let oneCard = document.getElementById("card" + tagMenu.value);
    let getTag = document.getElementById("getTag");
    oneCard.style.display = "inline";
    getTag.value = getTag.value + tagMenu.value + " ";
});


for (let card of allCard) {
    card.addEventListener("click", function () {
        this.style.display = "none";
        let getTag = document.getElementById("getTag");
        getTag.value = getTag.value.replace(card.innerHTML, "");
    });
}
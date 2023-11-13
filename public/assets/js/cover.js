var image = document.getElementById("coverPicture");
var appareil = document.getElementById("camera");

var previewPicture = function (e) {

    const [picture] = e.files

    if (picture) {

        var reader = new FileReader();

        // L'événement déclenché lorsque la lecture est complète
        reader.onload = function (e) {
            // On change l'URL de l'image (base64)
            image.style.backgroundImage = `url(${e.target.result})`;
            image.style.backgroundSize = "cover";
            appareil.style.opacity = 0;
            appareil.addEventListener("mouseover", () => {
                appareil.style.opacity = 1;
                setTimeout(() => {
                    appareil.style.opacity = 0;
                }, 1000);
            });
        }

        reader.readAsDataURL(picture)

    }
}
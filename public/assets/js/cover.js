var image = document.getElementById("#cover");

var previewPicture = function (e) {

    const [picture] = e.files

    if (picture) {

        var reader = new FileReader();

        // L'événement déclenché lorsque la lecture est complète
        reader.onload = function (e) {
            // On change l'URL de l'image (base64)
            image.src = e.target.result
        }

        // On lit le fichier "picture" uploadé
        reader.readAsDataURL(picture)

    }
}
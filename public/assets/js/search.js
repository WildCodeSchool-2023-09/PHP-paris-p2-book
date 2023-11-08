function toggleDisplay(element) {
    if (element.classList.contains("hidden")) {
        element.classList.remove("hidden");
        element.classList.add("shown");
        element.style.display = "flex";
    }
    else if (element.classList.contains("shown")) {
        element.classList.remove("shown");
        element.classList.add("hidden");
        element.style.display = "none";
    }
}

const searchSettingsBtn = document.querySelector('.btn.settings');
const searchSettingsBox = document.querySelector('#search-box');
searchSettingsBtn.addEventListener('click', function(){toggleDisplay(searchSettingsBox)});

const genreBtn = document.querySelector('.filter label[for="genre"]');
const genreSelect = document.querySelector('.filter select#genre');
genreBtn.addEventListener('click', function(){toggleDisplay(genreSelect)});

const tagBtn = document.querySelector('.filter label[for="tag"]');
const tagSelect = document.querySelector('.filter select#tag');
tagBtn.addEventListener('click', function(){toggleDisplay(tagSelect)});

const sortDateBtn = document.querySelector('.sort.date');
const sortDateIcon = document.querySelector('.sort.date .btn.sort');
sortDateBtn.addEventListener('click', function() {
    sortDateIcon.classList.toggle('reversed');
});

const sortNoteBtn = document.querySelector('.sort.note');
const sortNoteIcon = document.querySelector('.sort.note .btn.sort');
sortNoteBtn.addEventListener('click', function() {
    sortNoteIcon.classList.toggle('reversed');
});

const sortReviewsBtn = document.querySelector('.sort.reviews');
const sortReviewsIcon = document.querySelector('.sort.reviews .btn.sort');
sortReviewsBtn.addEventListener('click', function() {
    sortReviewsIcon.classList.toggle('reversed');
});
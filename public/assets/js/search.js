function toggleDisplay(buttonSelector, targetSelector, defaultDisplay) {
    const button = document.querySelector(buttonSelector);
    const target = document.querySelector(targetSelector);
    button.addEventListener('click', function(){
        if (target.classList.contains("hidden")) {
            target.style.display = defaultDisplay;
        }
        else {
            target.style.display = "none";
        }
        target.classList.toggle("hidden");
    });
}

function toggleSorting(buttonSelector, targetSelector, inputValue) {
    const button = document.querySelector(buttonSelector);
    const target = document.querySelector(targetSelector);
    const sortBy = document.querySelector('input#sort-by');
    const sortOrder = document.querySelector('input#sort-order');
    button.addEventListener('click', function(){
        target.classList.toggle('reversed');
        sortBy.setAttribute('value', inputValue);
        if (target.className.includes('reversed')) {
            sortOrder.setAttribute('value', 'ASC');
        }
        else {
            sortOrder.setAttribute('value', 'DESC');   
        }
    });
}

toggleDisplay('.btn.settings', '#search-box', 'flex');
toggleDisplay('.filter label[for="genre"]', '.filter .params#genre', 'block');
toggleDisplay('.filter label[for="tag"]', '.filter .params#tag', 'block');

toggleSorting('.sort.date', '.sort.date .btn.sort', 'date');
toggleSorting('.sort.note', '.sort.note .btn.sort', 'note');
toggleSorting('.sort.reads', '.sort.reads .btn.sort', 'reads');

const searchField = document.querySelector("#search-field");

searchField.addEventListener('focusin', function() {
    searchField.setAttribute('placeholder', '');
});
searchField.addEventListener('focusout', function(){
    searchField.setAttribute('placeholder', 'Search');
});
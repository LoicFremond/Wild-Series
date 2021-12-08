const $ = require('jquery');

$(document).ready(function () {
    $('#inputSearch').keyup(function () {
        let inputSearch = $(this).val();
        let data = 'q=' + inputSearch;
        console.log(data);
    })
});

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

import logoPath from '../images/logo.png';

let html = `<img src="${logoPath}" alt="Wild-Series logo">`;

import bgPath from '../images/bg.png';

let bg = `<img src="${bgPath}" alt="Background">`;

import languagePath from '../images/language.png';

let language = `<img src="${languagePath}" alt="Language Switcher">`;

import 'bootstrap-icons/font/bootstrap-icons.css';

require('bootstrap');
require('select2');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(() => {
    $('[data-toggle="popover"]').popover();
    $('select').select2();
    $('.toast').toast({delay: 2500});
    $('.toast').toast('show');
});

// script for update image into CRUD
// listen the change input poster

let box = document.querySelector('.watch-js');
let img = document.getElementById('img');

if (box.value !== null) {
    if (img !== null) {
        img.setAttribute('src', box.value);
    }

}

box.addEventListener('change', function () {
    document.getElementById('img').setAttribute('src', box.value);
})

document.querySelector("#watchlist").addEventListener('click', addToWatchlist);

function addToWatchlist(addToWatchlist) {

    addToWatchlist.preventDefault();

    // Get the link object you click in the DOM
    let watchlistLink = addToWatchlist.currentTarget;
    let link = watchlistLink.href;
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
    // Extract the JSON from the response
        .then(res => res.json())
    // Then update the icon
        .then(function(res) {
            let watchlistIcon = watchlistLink.firstElementChild;
            if (res.isInWatchlist) {
                watchlistIcon.classList.remove('bi-heart'); // Remove the .bi-heart (empty heart) from classes in <i> element
                watchlistIcon.classList.add('bi-heart-fill'); // Add the .bi-heart-fill (full heart) from classes in <i> element
            } else {
                watchlistIcon.classList.remove('bi-heart-fill'); // Remove the .bi-heart-fill (full heart) from classes in <i> element
                watchlistIcon.classList.add('bi-heart'); // Add the .bi-heart (empty heart) from classes in <i> element
            }

        });


}
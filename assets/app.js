import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
//import './styles/app.css';

import './js/toogletheme.js';
import './js/thumbnail.js';

// Solution simple : empêcher le scroll automatique de Turbo
let scrollPosition = 0;

document.addEventListener('turbo:before-visit', () => {
    scrollPosition = window.scrollY;
});

document.addEventListener('turbo:load', () => {
    if (scrollPosition > 0) {
        window.scrollTo(0, scrollPosition);
        scrollPosition = 0;
    }
});

//console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

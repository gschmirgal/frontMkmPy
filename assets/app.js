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

// Préservation du scroll uniquement pour les liens de pagination
let scrollPosition = 0;
let isPaginationClick = false;

document.addEventListener('turbo:click', (event) => {
    // Vérifier si le clic provient d'un lien de pagination
    const link = event.target.closest('a');
    if (link && link.closest('nav[aria-label="Pagination"]')) {
        isPaginationClick = true;
        scrollPosition = window.scrollY;
    } else {
        isPaginationClick = false;
        scrollPosition = 0;
    }
});

document.addEventListener('turbo:load', () => {
    if (isPaginationClick && scrollPosition > 0) {
        window.scrollTo(0, scrollPosition);
    }
    // Reset après usage
    isPaginationClick = false;
    scrollPosition = 0;
});

//console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

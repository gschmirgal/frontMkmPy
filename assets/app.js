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


// Installation et gestion du Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker enregistré avec succès:', registration.scope);
            })
            .catch(error => {
                console.log('Échec de l\'enregistrement du Service Worker:', error);
            });
    });
}

// Gestion de l'installation PWA
let deferredPrompt;
const installBanner = document.getElementById('install-banner');
const installBtn = document.getElementById('install-btn');

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Afficher la bannière d'installation
    if (installBanner) {
        installBanner.style.display = 'block';
    }
});

// Gestion du clic sur le bouton d'installation
document.addEventListener('DOMContentLoaded', () => {
    if (installBtn) {
        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;

                if (outcome === 'accepted') {
                    console.log('PWA installée avec succès');
                } else {
                    console.log('Installation PWA refusée');
                }

                deferredPrompt = null;
                if (installBanner) {
                    installBanner.style.display = 'none';
                }
            }
        });
    }
});

// Masquer la bannière si l'app est déjà installée
window.addEventListener('appinstalled', () => {
    console.log('PWA installée');
    if (installBanner) {
        installBanner.style.display = 'none';
    }
    deferredPrompt = null;
});



//console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

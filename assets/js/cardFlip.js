/**
 * Module de flip des cartes Magic double-face
 * Compatible Turbo.js avec préchargement
 */

let isFlipping = false;
let preloadImage = null;

function resetCardImage() {
    const cardImage = document.getElementById('cardImage');
    if (cardImage) {
        // Remettre sur la face avant
        cardImage.src = cardImage.dataset.front;
        cardImage.dataset.showing = 'front';
        cardImage.classList.remove('flipping');
        isFlipping = false;

        // Précharger l'image arrière
        if (cardImage.dataset.back && !preloadImage) {
            preloadImage = new Image();
            preloadImage.src = cardImage.dataset.back;
        }
    }
}

function flipCard() {
    if (isFlipping) return;

    const cardImage = document.getElementById('cardImage');
    if (!cardImage || !cardImage.dataset.back) return;

    isFlipping = true;

    // Animation de sortie
    cardImage.classList.add('flipping');

    setTimeout(() => {
        // Changer l'image
        if (cardImage.dataset.showing === 'front') {
            cardImage.src = cardImage.dataset.back;
            cardImage.dataset.showing = 'back';
        } else {
            cardImage.src = cardImage.dataset.front;
            cardImage.dataset.showing = 'front';
        }

        // Animation d'entrée
        setTimeout(() => {
            cardImage.classList.remove('flipping');
            isFlipping = false;
        }, 50);
    }, 200);
}

// Initialisation compatible Turbo
document.addEventListener('turbo:load', function () {
    resetCardImage();
});

// Fallback pour les navigateurs sans Turbo
document.addEventListener('DOMContentLoaded', function () {
    resetCardImage();
});
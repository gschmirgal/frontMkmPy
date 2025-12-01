// Tri simple des cartes avec localStorage
function sortCards(sortType) {
    localStorage.setItem('cardSortPreference', sortType);

    const container = document.querySelector('.row');
    if (!container) return;

    const cards = Array.from(container.children);

    cards.sort((a, b) => {
        if (sortType === 'collector_number') {
            return (parseInt(a.dataset.collectorNumber) || 9999) - (parseInt(b.dataset.collectorNumber) || 9999);
        }
        const aName = (a.dataset.cardName || '').toLowerCase();
        const bName = (b.dataset.cardName || '').toLowerCase();
        return sortType === 'name_desc' ? bName.localeCompare(aName) : aName.localeCompare(bName);
    });

    cards.forEach(card => container.appendChild(card));
}

// Toggle Art Series cards
function toggleArtSeries(hide) {
    localStorage.setItem('hideArtSeries', hide ? 'true' : 'false');

    const container = document.querySelector('.row');
    if (!container) return;

    const cards = Array.from(container.children);

    cards.forEach(card => {
        const cardName = (card.dataset.cardName || '').toLowerCase();
        if (cardName.includes('art series')) {
            card.style.display = hide ? 'none' : '';
        }
    });
}

function initSort() {
    const radios = document.querySelectorAll('input[name="sort"]');
    if (!radios.length) return;

    radios.forEach(radio => {
        radio.addEventListener('change', e => sortCards(e.target.value));
    });

    const saved = localStorage.getItem('cardSortPreference') || 'collector_number';
    const radio = document.querySelector(`input[value="${saved}"]`);
    if (radio) {
        radio.checked = true;
        sortCards(saved);
    }

    // Initialize Art Series filter
    const hideArtSeriesCheckbox = document.getElementById('hideArtSeries');
    if (hideArtSeriesCheckbox) {
        const hideArtSeries = localStorage.getItem('hideArtSeries') === 'true';
        hideArtSeriesCheckbox.checked = hideArtSeries;
        toggleArtSeries(hideArtSeries);
    }
}

// Initialisation
document.addEventListener('turbo:load', initSort);
document.addEventListener('DOMContentLoaded', initSort);

initSort();
// Service Worker pour PWA MKMpy
const CACHE_NAME = 'mkmpy-v2';
const urlsToCache = [
    '/manifest.json',
    '/icons/icon-192.png',
    '/icons/icon-512.png'
];

// Installation du Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                // Cache les fichiers un par un pour éviter qu'une erreur bloque tout
                return Promise.all(
                    urlsToCache.map(url => {
                        return cache.add(url).catch(err => {
                            console.warn('Failed to cache:', url, err);
                        });
                    })
                );
            })
    );
    // Force le nouveau Service Worker à devenir actif immédiatement
    self.skipWaiting();
});

// Interception des requêtes réseau
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Ne jamais mettre en cache la route racine (/) car elle fait une redirection
    if (url.pathname === '/' || url.pathname.startsWith('/cache/')) {
        event.respondWith(fetch(event.request));
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Retourne la version en cache ou fait une requête réseau
                return response || fetch(event.request);
            }
            )
    );
});

// Mise à jour du Service Worker
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
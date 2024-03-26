self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open('flasher-cache').then(function (cache) {
            return cache.addAll([
                '/projects/flasher/offline.php',
                '/projects/flasher/styles.css',
            ]);
        })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            if (response) {
                return response;
            }

            return fetch(event.request).then(function (networkResponse) {
                return caches.open('flasher-cache').then(function (cache) {
                    cache.put(event.request, networkResponse.clone());
                    return networkResponse;
                });
            }).catch(function () {
                return caches.match('/projects/flasher/offline.php');
            });
        })
    );
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.filter(function (cacheName) {
                    return cacheName.startsWith('flasher-cache') && cacheName !== 'flasher-cache';
                }).map(function (cacheName) {
                    return caches.delete(cacheName);
                })
            );
        })
    );
});

self.addEventListener('online', function (event) {
    event.waitUntil(
        caches.open('flasher-cache').then(function (cache) {
            return fetch('/projects/flasher/offline.php').then(function (response) {
                return cache.put('/projects/flasher/offline.php', response);
            });
        })
    );
});
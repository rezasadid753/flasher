// Listens for the 'install' event on the service worker and caches essential files
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

// Listens for the 'fetch' event on the service worker. This event is triggered whenever a fetch request is made. The event handler intercepts these requests to serve cached responses if available, or fetches from the network if not.
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

// Listens for the 'activate' event on the service worker. This event is typically fired after the service worker has been installed and a new version is ready to take control. The purpose of the 'activate' event handler is to clean up resources from previous versions of the service worker, ensuring that only the latest resources are cached and used.
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

// Listens for the 'online' event on the service worker. This event is triggered when the client regains network connectivity. The handler ensures that the latest version of essential offline resources is cached upon regaining connectivity.
self.addEventListener('online', function (event) {
    event.waitUntil(
        caches.open('flasher-cache').then(function (cache) {
            return fetch('/projects/flasher/offline.php').then(function (response) {
                return cache.put('/projects/flasher/offline.php', response);
            });
        })
    );
});
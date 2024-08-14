const staticCacheName = "pwa-v" + new Date().getTime();

/*
|--------------------------------------------------------------------------
| Cache On Install
|--------------------------------------------------------------------------
*/
self.addEventListener("install", (event) => {
    this.skipWaiting();

    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            fetch("/build/manifest.json")
                .then((response) => {
                    return response.json();
                })
                .then((assets) => {
                    const filesToCache = [
                        "/offline",
                        "/build/" +
                            assets[
                                "modules/Storefront/Resources/assets/public/sass/main.scss"
                            ].file,
                        "/build/" +
                            assets[
                                "modules/Storefront/Resources/assets/public/js/main.js"
                            ].file,
                        "/pwa/icons/48x48.png",
                        "/pwa/icons/72x72.png",
                        "/pwa/icons/96x96.png",
                        "/pwa/icons/128x128.png",
                        "/pwa/icons/144x144.png",
                        "/pwa/icons/152x152.png",
                        "/pwa/icons/192x192.png",
                        "/pwa/icons/384x384.png",
                        "/pwa/icons/512x512.png",
                    ];

                    return cache.addAll(filesToCache);
                });
        })
    );
});

/*
|--------------------------------------------------------------------------
| Clear Cache On Activate
|--------------------------------------------------------------------------
*/
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

/*
|--------------------------------------------------------------------------
| Serve From Cache
|--------------------------------------------------------------------------
*/
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});

const pwaVersion = 1715158717;

<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('manifest.json') }}">

<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ $config['theme_color'] }}">

<!-- Add to home-screen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}">
<meta name="application-name" content="{{ $config['short_name'] }}">
<!--/ Add to home-screen for Chrome on Android -->

<!-- Add to home-screen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{  $config['status_bar'] }}">
<meta name="apple-mobile-web-app-title" content="{{ $config['short_name'] }}">
<link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src') }}">
<!--/ Add to home-screen for Safari on iOS -->

<!-- Splashes --->
<link href="{{ config('pwa.splashes')['640x1136'] }}"
      media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['750x1334'] }}"
      media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1242x2208'] }}"
      media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1125x2436'] }}"
      media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['828x1792'] }}"
      media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1242x2688'] }}"
      media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1536x2048'] }}"
      media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1668x2224'] }}"
      media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['1668x2388'] }}"
      media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<link href="{{ config('pwa.splashes')['2048x2732'] }}"
      media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image"/>
<!--/ Splashes --->

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ $config['background_color'] }}">
<meta name="msapplication-TileImage" content="{{ data_get(end($config['icons']), 'src') }}">

<script type="module">
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            console.log('PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            console.log('PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>

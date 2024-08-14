<!DOCTYPE html>
<html>
    <head>
        <base href="{{ url('/') }}">
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>
            @yield('title') - {{ setting('store_name') }}
        </title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

        <style>
            :root {
                --base-font-family: "Manrope", sans-serif;
                --base-font-size: 15px;
                --font-light: 300;
                --font-normal: 400;
                --font-medium: 500;
                --default-border-radius: 8px;
                --color-primary: {{ tinycolor($themeColor->toString())->toHexString() }};
                --color-primary-darken: {{ generate_color_shade($themeColor->toString(), 0.1) }};
                --color-primary-transparent: {{ tinycolor($themeColor->toString())->setAlpha(0.1)->toString() }};
                --color-primary-transparent-darken: {{ tinycolor($themeColor->toString())->setAlpha(0.9)->toString() }};
                --color-secondary: #00bc65;
                --color-dark: #0e1e3e;
                --color-dark-2: #626f84;
                --color-dark-3: #a0aec0; 
                --color-light: #ffffff;
                --color-border: #e1e2e4;
                --color-red: #ff5748;
                --transition-primary: 0.2s ease-in-out;
            }
        </style>

        @vite([
            'modules/Storefront/Resources/assets/public/sass/auth.scss',
            'modules/Storefront/Resources/assets/public/js/auth.js',
        ])

        @stack('globals')
    </head>

    <body class="clearfix {{ is_rtl() ? 'rtl' : 'ltr' }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}">
        <div class="login-page">
            @yield('content')
        </div>
    </body>
</html>

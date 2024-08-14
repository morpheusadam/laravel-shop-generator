<?php

use Modules\Menu\MegaMenu\Menu;

if (!function_exists('resolve_theme_color')) {
    /**
     * Resolve color code by the given theme name.
     *
     * @param string $name
     *
     * @return string
     */
    function resolve_theme_color($color)
    {
        $colors = [
            'blue' => '#0068e1',
            'bondi-blue' => '#0095b6',
            'cornflower' => '#6453f7',
            'violet' => '#723881',
            'red' => '#f51e46',
            'yellow' => '#fa9928',
            'orange' => '#fd6602',
            'green' => '#59b210',
            'pink' => '#ff749f',
            'black' => '#2a3447',
            'indigo' => '#4b0082',
            'magenta' => '#f8008c',
        ];

        return $colors[$color] ?? '#0068e1';
    }
}

if (!function_exists('storefront_theme_color')) {
    function storefront_theme_color()
    {
        if (setting('storefront_theme_color') === 'custom_color') {
            return setting('storefront_custom_theme_color', '#0068e1');
        }

        return resolve_theme_color(setting('storefront_theme_color'));
    }
}

if (!function_exists('mail_theme_color')) {
    function mail_theme_color()
    {
        if (setting('storefront_mail_theme_color') === 'custom_color') {
            return setting('storefront_custom_mail_theme_color', '#0068e1');
        }

        return resolve_theme_color(setting('storefront_mail_theme_color'));
    }
}

if (!function_exists('mega_menu_classes')) {
    function mega_menu_classes(Menu $menu, $type = 'category_menu')
    {
        $classes = [];

        if ($type === 'primary_menu') {
            array_push($classes, 'nav-item');
        }

        if ($menu->isFluid()) {
            array_push($classes, 'fluid-menu');
        } else if ($menu->hasSubMenus()) {
            array_push($classes, 'dropdown', 'multi-level');
        }

        return implode(' ', $classes);
    }
}

if (!function_exists('products_view_mode')) {
    /**
     * Get the products view mode.
     *
     * @return string
     */
    function products_view_mode()
    {
        return request('viewMode', 'grid');
    }
}

if (!function_exists('order_status_badge_class')) {
    /**
     * Get the products view mode.
     *
     * @param string $status
     *
     * @return string
     */
    function order_status_badge_class($status)
    {
        $classes = [
            'canceled' => 'badge-danger',
            'completed' => 'badge-success',
            'on_hold' => 'badge-warning',
            'pending_payment' => 'badge-warning',
            'refunded' => 'badge-danger',
        ];

        return $classes[$status] ?? 'badge-info';
    }
}

if (!function_exists('social_links')) {
    /**
     * Get the social links.
     *
     * @param string $status
     *
     * @return string
     */
    function social_links()
    {
        return collect([
            'lab la-facebook' => setting('storefront_facebook_link'),
            'lab la-twitter' => setting('storefront_twitter_link'),
            'lab la-instagram' => setting('storefront_instagram_link'),
            'lab la-youtube' => setting('storefront_youtube_link'),
        ])->reject(function ($link) {
            return is_null($link);
        });
    }
}

if (!function_exists('social_link_name')) {
    /**
     * Get the social link name.
     *
     * @param string $icon
     *
     * @return string
     */
    function social_link_name($icon)
    {
        return [
            'lab la-facebook' => trans('storefront::storefront.social_links.facebook'),
            'lab la-twitter' => trans('storefront::storefront.social_links.twitter'),
            'lab la-instagram' => trans('storefront::storefront.social_links.instagram'),
            'lab la-youtube' => trans('storefront::storefront.social_links.youtube'),
        ][$icon];
    }
}

if (!function_exists('font_url')) {
    /**
     * Get the url for the given font.
     *
     * @param string $font
     *
     * @return string
     */
    function font_url($font)
    {
        return match ($font) {
            'Rubik' => 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap',
            'Roboto' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap',
            'Open Sans' => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..800&display=swap',
            'Montserrat' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap',
            'Poppins' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap',
            'Nunito' => 'https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200..1000&display=swap',
            'Raleway' => 'https://fonts.googleapis.com/css2?family=Raleway:wght@100..900&display=swap',
            'Oswald' => 'https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap',
            'Quicksand' => 'https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap',
            'Hind' => 'https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500&display=swap',
            'Fira Sans' => 'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500&display=swap',
            'Mukta' => 'https://fonts.googleapis.com/css2?family=Mukta:wght@300;400;500&display=swap',
            'Karla' => 'https://fonts.googleapis.com/css2?family=Karla:wght@200..800&display=swap',
            'Barlow' => 'https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500&display=swap',
            'Source Sans 3' => 'https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@200..900&display=swap',
            'IBM Plex Sans' => 'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500&display=swap',
            'Work Sans' => 'https://fonts.googleapis.com/css2?family=Work+Sans:wght@100..900&display=swap'
        };
    }
}

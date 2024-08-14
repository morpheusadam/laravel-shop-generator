<?php

namespace Modules\Support\Services;

class ManifestService
{
    public function generate(): array
    {
        $manifest = [
            'id' => config('pwa.manifest.id'),
            'name' => setting('store_name') ?? config('pwa.manifest.name'),
            'description' => setting('store_tagline') ?? config('pwa.manifest.description'),
            'short_name' => setting('store_name') ?? config('pwa.manifest.short_name'),
            'dir' => setting('pwa_direction') ?? config('pwa.manifest.dir'),
            'start_url' => url(config('pwa.manifest.start_url')),
            'theme_color' => setting('pwa_theme_color') ?? config('pwa.manifest.theme_color'),
            'background_color' => setting('pwa_background_color') ?? config('pwa.manifest.background_color'),
            'status_bar' => setting('pwa_status_bar') ?? config('pwa.manifest.status_bar'),
            'display' => setting('pwa_display') ?? config('pwa.manifest.display'),
            'orientation' => setting('pwa_orientation') ?? config('pwa.manifest.orientation'),
            'lang' => config('pwa.manifest.lang'),
        ];

        if (config('pwa.manifest.icons')) {
            foreach (config('pwa.manifest.icons') as $icon) {
                $manifest['icons'][] = [
                    'src' =>  url($icon['path']),
                    'type' => $icon['type'],
                    'sizes' => $icon['sizes'],
                    'purpose' => $icon['purpose'],
                ];
            }
        }

        if (config('pwa.manifest.shortcuts')) {
            foreach (config('pwa.manifest.shortcuts') as $index => $shortcut) {
                $manifest['shortcuts'][$index] = [
                    'name' => trans($shortcut['name']),
                    'description' => trans($shortcut['description']),
                    'url' => $shortcut['url'],
                ];

                if (array_key_exists('icons', $shortcut)) {
                    $icons = [];

                    foreach ($shortcut['icons'] as $icon) {
                        $icon = [
                            'src' => $icon['src'],
                            'type' => $icon['type'],
                            'purpose' => $icon['purpose'],
                        ];
                        if (isset($icon['sizes'])) {
                            $icon['sizes'] = $shortcut['sizes'];
                        }
                        $icons[] = $icon;
                    }

                    $manifest['shortcuts'][$index]['icons'] = $icons;
                }
            }
        }

        if (config('pwa.manifest.screenshots')) {
            foreach (config('pwa.manifest.screenshots') as $screenshot) {
                $manifest['screenshots'][] = [
                    'src' => $screenshot['src'],
                    'label' => $screenshot['label'],
                    'type' => $screenshot['type'],
                    'sizes' => $screenshot['sizes'],
                    'form_factor' => $screenshot['form_factor'],
                ];
            }
        }

        if (config('pwa.manifest.custom')) {
            foreach (config('pwa.manifest.custom') as $tag => $value) {
                $manifest[$tag] = $value;
            }
        }

        return $manifest;
    }
}

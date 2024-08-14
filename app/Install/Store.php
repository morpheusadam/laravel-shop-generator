<?php

namespace FleetCart\Install;

use Modules\Setting\Entities\Setting;

class Store
{
    public function setup($request): void
    {
        Setting::setMany([
            'translatable' => [
                'store_name' => $request['store_name'],
            ],
            'store_email' => $request['store_email'],
            'store_phone' => $request['store_phone'],
            'search_engine' => $request['store_search_engine'],
            'algolia_app_id' => $request['algolia_app_id'],
            'algolia_secret' => $request['algolia_secret'],
            'meilisearch_host' => $request['meilisearch_host'],
            'meilisearch_key' => $request['meilisearch_key'],
        ]);
    }
}

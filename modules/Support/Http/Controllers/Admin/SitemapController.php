<?php

namespace Modules\Support\Http\Controllers\Admin;

use Modules\Support\Services\SitemapService;

class SitemapController
{
    public function create(SitemapService $sitemapService)
    {
        return view('support::admin.sitemap.index');
    }


    public function store(SitemapService $sitemapService)
    {
        $sitemapService->generate();

        return back()->with('success', trans('support::sitemap.messages.sitemap_generated_successfully'));
    }
}


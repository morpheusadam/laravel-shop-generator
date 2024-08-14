<?php

namespace Modules\Support\Console;

use Illuminate\Console\Command;
use Modules\Support\Services\SitemapService;

class SitemapGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SitemapService $sitemapService)
    {
        $sitemapService->generate();
        $this->info('Sitemap Generated Successfully');
    }
}

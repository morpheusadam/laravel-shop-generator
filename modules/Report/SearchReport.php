<?php

namespace Modules\Report;

use Modules\Product\Entities\SearchTerm;

class SearchReport extends Report
{
    protected $filters = [];


    public function query()
    {
        return SearchTerm::orderByDesc('hits')
            ->when(request()->has('keyword'), function ($query) {
                $query->where('term', 'LIKE', request('keyword') . '%');
            });
    }


    protected function view()
    {
        return 'report::admin.reports.search_report.index';
    }
}

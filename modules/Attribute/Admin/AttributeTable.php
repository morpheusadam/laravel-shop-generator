<?php

namespace Modules\Attribute\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;

class AttributeTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $defaultRawColumns = [
        'is_filterable',
    ];

    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('attribute_set', function ($attribute) {
                return $attribute->attributeSet->name;
            })
            ->addColumn('is_filterable', function ($attribute) {
                return $attribute->is_filterable
                    ? '<span class="badge badge-success">' . trans('attribute::admin.table.yes') . '</span>'
                    : '<span class="badge badge-danger">' . trans('attribute::admin.table.no') . '</span>';
            });
    }
}

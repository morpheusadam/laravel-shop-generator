<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogCategory;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Blog\Http\Requests\SaveBlogCategoryRequest;

class BlogCategoryController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = BlogCategory::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'blog::blog.categories.name';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'blog::admin.categories';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SaveBlogCategoryRequest::class;
}

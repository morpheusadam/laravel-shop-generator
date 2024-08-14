<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogTag;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Blog\Http\Requests\SaveBlogTagRequest;

class BlogTagController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = BlogTag::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'blog::blog.tags.name';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'blog::admin.tags';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SaveBlogTagRequest::class;
}

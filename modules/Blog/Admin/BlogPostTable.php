<?php

namespace Modules\Blog\Admin;

use Modules\Admin\Ui\AdminTable;
use Modules\Blog\Entities\BlogPost;
use Yajra\DataTables\Exceptions\Exception;

class BlogPostTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $defaultRawColumns = [
        'publish_status',
    ];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('featured_image', function (BlogPost $blogPost) {
                return view('admin::partials.table.image', [
                    'file' => $blogPost->featured_image,
                ]);
            })
            ->addColumn('title', function ($blogPost) {
                return $blogPost->title;
            })
            ->addColumn('user', function ($blogPost) {
                return $blogPost->user->full_name;
            })
            ->addColumn('publish_status', function ($blogPost) {
                return match ($blogPost->publish_status) {
                    BlogPost::PUBLISHED => '<span class="badge badge-success">' . trans('blog::blog.posts.form.publish_status.published') . '</span>',
                    BlogPost::UNPUBLISHED => '<span class="badge badge-danger">' . trans("blog::blog.posts.form.publish_status.unpublished") . '</span>',
                };
            });
    }
}

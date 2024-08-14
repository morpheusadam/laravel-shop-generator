<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogTag;
use Modules\Blog\Entities\BlogPost;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\BlogCategory;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Blog\Http\Requests\SaveBlogPostRequest;

class BlogPostController extends Controller
{
    use HasCrudActions {
        store as public crudStore;
    }

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'blog::blog.posts.name';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'blog::admin.posts';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SaveBlogPostRequest::class;


    public function store()
    {
        request()->request->add([
            'user_id' => Auth::id(),
        ]);

        $this->disableSearchSyncing();

        $entity = $this->getModel()->create(
            $this->getRequest('store')->all()
        );

        $this->searchable($entity);

        $message = trans('admin::messages.resource_created', ['resource' => $this->getLabel()]);

        if (request()->query('exit_flash')) {
            session()->flash('exit_flash', $message);
        }

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => $message,
                    'blog_post_id' => $entity->id,
                ], 200
            );
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess($message);
    }


    public function create()
    {
        $data = array_merge([
            'blogCategories' => $this->getBlogCategories(),
            'blogTags' => $this->getBlogTags(),
            $this->getResourceName() => $this->getModel(),
        ], $this->getFormData('create'));

        return view("{$this->viewPath}.create", $data);
    }


    public function update($id){
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $entity->update(
            $this->getRequest('update')->all()
        );

        $this->searchable($entity);

        $message = trans('admin::messages.resource_updated', ['resource' => $this->getLabel()]);

        if (request()->query('exit_flash')) {
            session()->flash('exit_flash', $message);
        }

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => $message,
                ], 200
            );
        }
    }


    private function getBlogCategories()
    {
        return BlogCategory::all()->sortBy('name')->pluck('name', 'id')
            ->prepend(trans('admin::admin.form.please_select'), '');
    }


    private function getBlogTags()
    {
        return BlogTag::all()->sortBy('name')->pluck('name', 'id');
    }


    public function edit($id)
    {
        $data = array_merge([
            'blogCategories' => $this->getBlogCategories(),
            'blogTags' => $this->getBlogTags(),
            $this->getResourceName() => $this->getEntity($id),
        ], $this->getFormData('edit', $id));

        return view("{$this->viewPath}.edit", $data);
    }
}

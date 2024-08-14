<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;
use Modules\Blog\Entities\BlogCategory;

class SaveBlogCategoryRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'blog::attributes.blogs.categories';


    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => $this->getSlugRule(),
        ];
    }


    private function getSlugRule(): array
    {
        $rules = $this->route()->getName() === 'admin.blog_categories.update' ? ['required'] : ['sometimes'];

        $slug = BlogCategory::where('id', $this->id)
            ->value('slug');

        $rules[] = Rule::unique('blog_categories', 'slug')->ignore($slug, 'slug');

        return $rules;
    }
}

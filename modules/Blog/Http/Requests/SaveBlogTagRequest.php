<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Blog\Entities\BlogTag;
use Modules\Core\Http\Requests\Request;

class SaveBlogTagRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'blog::attributes.blogs.tags';


    public function rules()
    {
        return [
            'slug' => $this->getSlugRule(),
            'name' => 'required',
        ];
    }


    private function getSlugRule(): array
    {
        $rules = $this->route()->getName() === 'admin.blog_tags.update' ? ['required'] : ['sometimes'];

        $slug = BlogTag::where('id', $this->id)
            ->value('slug');

        $rules[] = Rule::unique('blog_tags', 'slug')->ignore($slug, 'slug');

        return $rules;
    }
}

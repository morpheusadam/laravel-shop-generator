<div class="box">
    <div class="box-header">
        <h5>{{ trans('blog::blog.posts.groups.categories') }}</h5>
    </div>

    <div class="box-body">
        <div class="form-group">
            <label for="blog_category_id" class="control-label text-left">
                {{ trans('blog::attributes.posts.category') }}
            </label>
            
            <select name="blog_category_id" id="blog_category_id" class="form-control custom-select-black" x-model="form.blog_category_id">
                @foreach ($blogCategories as $id => $label)
                    <option value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>

            <template x-if="errors.has('blog_category_id')">
                <span class="help-block text-red" x-text="errors.get('blog_category_id')"></span>
            </template>
        </div>
    </div>
</div>
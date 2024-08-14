<div class="box">
    <div class="box-header">
        <h5>{{ trans('blog::blog.posts.groups.seo') }}</h5>
    </div>

    <div class="box-body">
        @if (request()->routeIs('admin.blog_posts.edit'))
            <div class="form-group">
                <label for="slug" class="control-label text-left">
                    {{ trans('blog::attributes.posts.slug') }}
                </label>
                
                <input type="text" name="slug" id="slug" class="form-control" x-model="form.slug">

                <template x-if="errors.has('slug')">
                    <span class="help-block text-red" x-text="errors.get('slug')"></span>
                </template>
            </div>
        @endif

        <div class="form-group">
            <label for="meta.meta_title" class="control-label text-left">
                {{ trans('meta::attributes.meta_title') }}
            </label>
            
            <input type="text" name="meta.meta_title" id="meta.meta_title" class="form-control" x-model="form.meta.meta_title">

            <template x-if="errors.has('meta.meta_title')">
                <span class="help-block text-red" x-text="errors.get('meta.meta_title')"></span>
            </template>
        </div>

        <div class="form-group">
            <label for="meta.meta_description" class="control-label text-left">
                {{ trans('meta::attributes.meta_description') }}
            </label>
            
            <textarea name="meta.meta_description" id="meta.meta_description" class="form-control" cols="30" rows="10" x-model="form.meta.meta_description"></textarea>

            <template x-if="errors.has('meta.meta_description')">
                <span class="help-block text-red" x-text="errors.get('meta.meta_description')"></span>
            </template>
        </div>
    </div>
</div>
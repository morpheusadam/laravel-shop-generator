<div class="box">
    <div class="box-header">
        <h5>{{ trans('blog::blog.posts.groups.general') }}</h5>
    </div>

    <div class="box-body clearfix">
        <div class="form-group">
            <label for="title" class="control-label text-left">
                {{ trans('blog::attributes.posts.title') }} 
                
                <span class="text-red">*</span>
            </label>
            
            <input type="text" name="title" id="title" class="form-control" x-model="form.title" autofocus>

            <template x-if="errors.has('title')">
                <span class="help-block text-red" x-text="errors.get('title')"></span>
            </template>
        </div>

        <div class="form-group">
            <label for="description" class="control-label text-left" @click="focusDescriptionField">
                {{ trans('blog::attributes.posts.description') }}
                
                <span class="text-red">*</span>
            </label>
            
            <textarea name="description" id="description" class="form-control wysiwyg" x-model="form.description">
            </textarea>

            <template x-if="errors.has('description')">
                <span class="help-block text-red" x-text="errors.get('description')"></span>
            </template>
        </div>
    </div>
</div>
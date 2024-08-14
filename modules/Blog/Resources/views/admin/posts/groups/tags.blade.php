<div class="box">
    <div class="box-header">
        <h5>{{ trans('blog::blog.posts.groups.tags') }}</h5>
    </div>

    <div class="box-body">
        <div class="form-group">
            <label for="tags" class="control-label text-left">
                {{ trans('blog::attributes.posts.tags') }}
            </label>
            
            <select name="tags" id="tags" class="selectize" multiple x-model="form.tags">
                @foreach ($blogTags as $id => $label)
                    <option value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>

            <template x-if="errors.has('tags')">
                <span class="help-block text-red" x-text="errors.get('tags')"></span>
            </template>
        </div>
    </div>
</div>
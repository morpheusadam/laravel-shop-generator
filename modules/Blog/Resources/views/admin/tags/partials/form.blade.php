<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label text-left">
                {{ trans('blog::attributes.tags.name') }} 
                
                <span class="text-red">*</span>
            </label>
            
            <div class="col-sm-9">
                <input type="text" name="name" value="{{ old('name', $blogTag->name) }}" id="name" class="form-control" autofocus>

                {!! $errors->first('name', '<span class="help-block text-red">:message</span>') !!}
            </div>
        </div>

        @if (request()->routeIs('admin.blog_tags.edit'))
            <div class="form-group">
                <label for="slug" class="col-sm-3 control-label text-left">
                    {{ trans('blog::attributes.tags.slug') }} 
                    
                    <span class="text-red">*</span>
                </label>
                
                <div class="col-sm-9">
                    <input type="text" name="slug" value="{{ old('slug', $blogTag->slug) }}" id="slug" class="form-control">

                    {!! $errors->first('slug', '<span class="help-block text-red">:message</span>') !!}
                </div>
            </div>
        @endif

        <div class="form-group">
            <div class="col-md-offset-3 col-md-10">
                <button type="submit" class="btn btn-primary" data-loading> 
                    {{ trans('admin::admin.buttons.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
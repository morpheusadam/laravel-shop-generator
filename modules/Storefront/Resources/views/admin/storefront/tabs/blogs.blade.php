<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('storefront_blogs_section_enabled', trans('storefront::attributes.section_status'), trans('storefront::storefront.form.enable_blogs_section'), $errors, $settings) }}
        {{ Form::text('translatable[storefront_blogs_section_title]', trans('storefront::attributes.section_title'), $errors, $settings) }}
        {{ Form::select('storefront_recent_blogs', trans('storefront::attributes.recent_blogs'), $errors, trans('storefront::storefront.form.recent_blogs') ,$settings) }}
    </div>
</div>

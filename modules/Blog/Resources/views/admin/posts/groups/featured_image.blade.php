<div class="box">
    <div class="box-header">
        <h5>{{ trans('blog::blog.posts.groups.featured_image') }}</h5>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="blog-featured-image" @click="addFeaturedImage">
                    <template x-if="!form.featured_image.path">
                        <div class="image-holder">
                            <img src="{{ asset('build/assets/placeholder_image.png') }}" class="placeholder-image" alt="Placeholder image">
                        </div>
                    </template>

                    <template x-if="form.featured_image.path">
                        <div class="image-holder">
                            <img :src="form.featured_image.path" alt="Featured image">

                            <button type="button" class="btn remove-image" @click.stop="removeFeaturedImage">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M6.00098 17.9995L17.9999 6.00053" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M17.9999 17.9995L6.00098 6.00055" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
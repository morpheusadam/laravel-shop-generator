<template>
    <div class="blog-post-card">
        <div class="blog-post">
            <a
                :href="route('blog_posts.show', blogPost.slug)"
                class="blog-post-featured-image overflow-hidden"
            >
                <div
                    class="image-placeholder"
                    v-if="blogPost.featured_image.length === 0"
                >
                    <img
                        :src="`${baseUrl}/build/assets/image-placeholder.png`"
                        alt="Blog featured image"
                    />
                </div>

                <img
                    :src="blogPost.featured_image.path"
                    alt="Blog featured image"
                    v-else
                />
            </a>

            <div class="blog-post-body">
                <ul class="list-inline blog-post-meta">
                    <li class="d-flex align-items-center">
                        <i class="las la-user"></i>
                        {{ blogPost.user_name }}
                    </li>

                    <li class="d-flex align-items-center">
                        <i class="las la-calendar"></i>
                        {{ dateFormat(blogPost.created_at, "dd mmm, yyyy") }}
                    </li>
                </ul>

                <h3 class="blog-post-title">
                    <a :href="route('blog_posts.show', blogPost.slug)">
                        {{ blogPost.title }}
                    </a>
                </h3>

                <p class="blog-post-short-description">
                    {{ blogPost.short_description }}
                </p>

                <a
                    :href="route('blog_posts.show', blogPost.slug)"
                    class="blog-post-read-more"
                >
                    {{ $trans("storefront::blog.blog_posts.read_more") }}
                    <i class="las la-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import dateFormat from "dateformat";

Vue.prototype.dateFormat = dateFormat;

export default {
    props: {
        blogPost: {
            required: true,
            type: Object,
        },
    },

    computed: {
        baseUrl() {
            return window.FleetCart.baseUrl;
        },
    },
};
</script>

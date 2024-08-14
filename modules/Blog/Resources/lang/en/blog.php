<?php

use Modules\Blog\Entities\BlogPost;

return [
    'posts' => [
        'name' => 'Blog Post',
        'groups' => [
            'featured_image' => 'Featured Image',
            'publish' => 'Publish',
            'categories' => 'Categories',
            'tags' => 'Tags',
            'general' => 'General',
            'seo' => 'SEO'
        ],
        'form' => [
            'enable_the_blog_category' => 'Enable the blog category',
            'publish_status' => [
                BlogPost::PUBLISHED => 'Published',
                BlogPost::UNPUBLISHED => 'Unpublished'
            ],
        ],
    ],
    'categories' => [
        'name' => 'Blog Category'
    ],
    'tags' => [
        'name' => 'Blog Tag'
    ]
];

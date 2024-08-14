<?php

return [
    'admin.blog_posts' => [
        'index' => 'blog::permissions.posts.index',
        'create' => 'blog::permissions.posts.create',
        'edit' => 'blog::permissions.posts.edit',
        'destroy' => 'blog::permissions.posts.destroy',
    ],
    'admin.blog_categories' => [
        'index' => 'blog::permissions.categories.index',
        'create' => 'blog::permissions.categories.create',
        'edit' => 'blog::permissions.categories.edit',
        'destroy' => 'blog::permissions.categories.destroy',
    ],
    'admin.blog_tags' => [
        'index' => 'blog::permissions.tags.index',
        'create' => 'blog::permissions.tags.create',
        'edit' => 'blog::permissions.tags.edit',
        'destroy' => 'blog::permissions.tags.destroy',
    ],
];

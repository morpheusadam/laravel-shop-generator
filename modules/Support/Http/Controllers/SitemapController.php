<?php

namespace Modules\Support\Http\Controllers;

class SitemapController
{
    public function index()
    {
        $sitemapIndices = [
            'store' => [
                'products' => [
                    'title' => 'Products',
                    'href' => route('products.index'),
                ],
                'categories' => [
                    'title' => 'Categories',
                    'href' => route('categories.index'),
                ],
                'brands' => [
                    'title' => 'Brands',
                    'href' => route('brands.index'),
                ],
            ],
            'blog' => [
                'posts' => [
                    'title' => 'Posts',
                    'href' => route('blog_posts.index'),
                ],
            ],
            'website' => [
                'register' => [
                    'title' => 'Register',
                    'href' => route('register'),
                ],
                'login' => [
                    'title' => 'Log In',
                    'href' => route('login'),
                ],
                'contact-us' => [
                    'title' => 'Contact Us',
                    'href' => route('contact.store'),
                ],
            ],
        ];

        return view('support::sitemap.index', compact('sitemapIndices'));
    }
}


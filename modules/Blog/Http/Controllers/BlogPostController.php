<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogPost;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogPostTranslation;

class BlogPostController extends Controller
{
    public const NUMBER_OF_RECENT_BLOGS_IN_SIDEBAR = 5;

    public const NUMBER_OF_TOTAL_BLOGS_IN_BLOGS_INDEX_PAGE = 10;


    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $blogPosts = BlogPost::published()
            ->latest()
            ->paginate(self::NUMBER_OF_TOTAL_BLOGS_IN_BLOGS_INDEX_PAGE);

        $recentBlogPosts = BlogPost::published()
            ->latest()
            ->take(self::NUMBER_OF_RECENT_BLOGS_IN_SIDEBAR)->get();

        $blogCategories = BlogCategory::withCount(['blogPosts'=> fn($query) => $query->published()])->latest()->get();

        $indexTitle = trans('storefront::blog.blog');

        return view('storefront::public.blogs.posts.index', compact('indexTitle', 'blogPosts', 'recentBlogPosts', 'blogCategories'));
    }


    /**
     * Show the specified resource.
     *
     * @param $slug
     *
     * @return Renderable
     */
    public function show($slug)
    {
        $blogPost = BlogPost::findBySlug($slug)->published()->firstOrFail();
        $blogCategories = BlogCategory::withCount(['blogPosts'=> fn($query) => $query->published()])->latest()->get();

        if (!$blogPost) {
            abort(404);
        }

        $recentBlogPosts = BlogPost::published()
            ->latest()
            ->where('id', '<>', $blogPost->id)
            ->take(self::NUMBER_OF_RECENT_BLOGS_IN_SIDEBAR)
            ->get();

        return view('storefront::public.blogs.posts.show', compact('blogPost', 'recentBlogPosts', 'blogCategories'));
    }


    /**
     * Show the specified resource.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public function search(Request $request)
    {
        $blogCategories = BlogCategory::withCount(['blogPosts'=> fn($query) => $query->published()])->latest()->get();

        $blogPosts = BlogPost::published()->whereHas('translations', function($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->input('query') . '%');
        })->paginate(self::NUMBER_OF_TOTAL_BLOGS_IN_BLOGS_INDEX_PAGE);;

        $recentBlogPosts = BlogPost::published()
            ->latest()
            ->take(self::NUMBER_OF_RECENT_BLOGS_IN_SIDEBAR)
            ->get();

        $indexTitle = trans('storefront::blog.search_results_for') . ' ' . $request->input('query');

        return view('storefront::public.blogs.posts.index', compact('indexTitle', 'blogCategories', 'blogPosts', 'recentBlogPosts'));
    }
}
